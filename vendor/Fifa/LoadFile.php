<?php

namespace Fifa;

use PHPExcel_IOFactory;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use Cake\Core\Configure;

class LoadFile {

    public $uuid;
    private $compromisosTmp;
    public $output;

    public function __construct() {
        $this->compromisosTmp = TableRegistry::get('CompromisosTmp');
        $this->uuid = Text::uuid();
		Configure::load('fifa', 'default');
    }

    public function load(array $dataIn) {
        $prefijo = substr(uniqid(), -5);
        $uploadPath = 'uploads/files/load_' . date("ymd");
        $allowfiletypes = array('xls', 'xlsx');
        $files = [];


        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }




        foreach ($dataIn as $key => $data) {

            $fileName = $prefijo . '_' . $data['name'];
            $uploadFile = $uploadPath . '/' . $fileName;
            $TipoArchivo = pathinfo($uploadFile, PATHINFO_EXTENSION);

            if (in_array($TipoArchivo, $allowfiletypes)) {
                if (move_uploaded_file($data['tmp_name'], $uploadFile)) {
                    $files[$key] = array('file' => $uploadFile);
                }
            } else {
                $this->output = ['exito' => FALSE, 'mensaje' => 'Solo se permite archivos con extension .xls o .xlsx'];
                break;
            }
        }

        if ($files) {
            $this->output = $this->InsertCompromisos($files);
            if ($this->output['exito']) {
                $this->output = $this->Insertcdps($files);
            }
        }
        $this->output['upload'] = $files;
        return $this->output;
    }

    private function InsertCompromisos($files) {
        $objPHPExcel = PHPExcel_IOFactory::load($files['compromiso']['file']);

        $query = $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $index = $sheetData[1];
        $index = array_map('strtolower', str_replace(" ", "_", $index));
        $index['load_id'] = 'load_id';
        $output = [];
        $insert = array();
        unset($sheetData[1]);
        foreach ($sheetData as $key => $data) {
            $data['L'] = str_replace(',', '', $data['L']);
            $data['M'] = str_replace(',', '', $data['M']);
            $data['N'] = str_replace(',', '', $data['N']);
            $data['O'] = str_replace(',', '', $data['O']);
            $data['load_id'] = $this->uuid;

            $insert[] = array_combine($index, $data);
        }
        //echo'<pre>';print_r($insert);die();
        $insert = $this->compromisosTmp->newEntities($insert);
        $this->compromisosTmp->saveMany($insert);
        
        //update compromiso solo año 2016
        if (date('Y') == 2017) {
            $this->updateCompromisos();
        }

        $output = $this->validateTipoDocumentoSoporte();

        //si validación de tipo documento es exito
        if ($output['exito']) {
            //validar terceros
            $output = $this->validateTercero();
            if ($output['exito']) {
                //insert table final
                $output = ['exito' => TRUE, 'mensaje' => '', 'uuid' => $this->uuid];
            }
        }
        return $output;
    }

    private function validateTipoDocumentoSoporte() {
		$tipoDocumentoSoporte = Configure::read('tipoDocumentoSoporte');
		$tipo_documento_soporte_permitido=[];
		foreach($tipoDocumentoSoporte as $data){
			$tipo_documento_soporte_permitido=array_merge($tipo_documento_soporte_permitido,$data);
		}
		
      /*  $tipo_documento_soporte_permitido = [
            'CONTRATO DE ARRENDAMIENTO',
            'CONTRATO DE COMPRA VENTA Y SUMINISTROS',
            'CONTRATO DE PRESTACION DE SERVICIOS',
            'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES',
            'CONTRATO INTERADMINISTRATIVO',
            'FACTURA',
            'NOMINA',
            'ORDEN DE COMPRA',
            'RESOLUCION', 
            'DECRETO', 
            'SOLICITUD', 
            'POLIZA', 
            'REEMBOLSO CAJA MENOR',
            'CONVENIO'
        ];*/
        $tipo_documento_soporte_no_permitido = [];
        $output = [];

        //$compromisosTmp = TableRegistry::get('CompromisosTmp');
        $query = $this->compromisosTmp->find()->select(['tipo_documento_soporte'])->where(['load_id' => $this->uuid])->group('tipo_documento_soporte');
        foreach ($query as $documento) {
            if (!in_array($documento->tipo_documento_soporte, $tipo_documento_soporte_permitido)) {
                $tipo_documento_soporte_no_permitido[] = $documento->tipo_documento_soporte;
            }
        }

        if (count($tipo_documento_soporte_no_permitido)) {
            $output = ['exito' => FALSE, 'mensaje' => 'El archivo de compromisos contiene tipo documento soporte no validos ' . implode(", ", $tipo_documento_soporte_no_permitido)];
        } else {
            $output = ['exito' => TRUE, 'mensaje' => ''];
        }
        return $output;
    }

    private function validateTercero() {
        $terceros_no_creado = [];
        $output = [];

        $query = $this->compromisosTmp->find()
                ->select(['CompromisosTmp.identificacion', 'CompromisosTmp.nombre_razon_social'])
                ->where(['load_id' => $this->uuid, 'Users.identification is null'])
                ->leftJoin(['Users' => 'users'], ['Users.identification = CompromisosTmp.identificacion'])
                ->group('CompromisosTmp.identificacion');

        foreach ($query as $tercero) {
            $terceros_no_creado[] = $tercero->identificacion . ':' . $tercero->nombre_razon_social;
        }

        if (count($terceros_no_creado)) {
            $output = ['exito' => FALSE, 'mensaje' => 'El archivo de compromisos contiene terceros no creados ' . implode(', ', $terceros_no_creado)];
        } else {
            $output = ['exito' => TRUE, 'mensaje' => ''];
        }
        return $output;
    }

    private function updateCompromisos() {
		
		$compromisos = [
				//['compromiso' =>216,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>6317,'documento_soporte' =>'RESOLUCION'],
				['compromiso' =>12017,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS'],
				['compromiso' =>117,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>217,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>317,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>417,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>617,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>717,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>817,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>917,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>1017,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>1117,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>2217,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>2317,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>2617,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>2717,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>2817,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>2917,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>3017,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>3117,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>3217,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>3317,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>3417,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>3517,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>3617,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>3917,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>4017,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>4117,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>4217,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>4317,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>4417,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>4517,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>4617,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>4817,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>4917,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>5017,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>5117,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>5217,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>5317,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>5417,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>5517,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>6117,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>6717,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>7017,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>7417,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>7517,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>7617,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>7717,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>7817,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>7917,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>8017,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>8417,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>9317,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>9417,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>11017,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>12117,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>12217,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>12317,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>12517,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>12817,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>14017,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>15517,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>17017,'documento_soporte' =>'CONTRATO DE PRESTACION DE SERVICIOS - PROFESIONALES'],
				['compromiso' =>517,'documento_soporte' =>'REEMBOLSO DE CAJA MENOR'],
				['compromiso' =>10617,'documento_soporte' =>'REEMBOLSO DE CAJA MENOR'],
				['compromiso' =>16217,'documento_soporte' =>'REEMBOLSO DE CAJA MENOR']
			];


        foreach ($compromisos as $data) {
            $query = $this->compromisosTmp->find();
            $query->update()
                    ->set(['tipo_documento_soporte' => $data['documento_soporte']])
                    ->where(['compromisos' => $data['compromiso'], 'load_id' => $this->uuid])
                    ->execute();					
        }
    }

    private function Insertcdps($files) {
        $objPHPExcel = PHPExcel_IOFactory::load($files['cdp']['file']);
        $cdpTmp = TableRegistry::get('CdpsTmp');
        $query = $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $index = $sheetData[1];
        $index = array_map('strtolower', str_replace(" ", "_", $index));
        $index['load_id'] = 'load_id';
        $insert = array();
        unset($sheetData[1]);
        foreach ($sheetData as $key => $data) {
            $data['M'] = str_replace(',', '', $data['M']);
            $data['N'] = str_replace(',', '', $data['N']);
            $data['O'] = str_replace(',', '', $data['O']);
            $data['P'] = str_replace(',', '', $data['P']);
            $data['load_id'] = $this->uuid;            
            $insert[] = array_combine($index, $data);
        }
        
        $insert = $cdpTmp->newEntities($insert);       
        $cdpTmp->saveMany($insert);
        return ['exito' => TRUE, 'mensaje' => '', 'uuid' => $this->uuid];
    }

}

<?php
 
  // require "vendor/autoload.php";
  
class Excel
{
  
    /** @var PHPExcel */
    protected $PHPExcel;

    /** @var string */
    protected $title;

    /** @var int */
    protected $sheets = 0;

    /**
     * Helper para PHPExcel
     *
     * @see PHPExcel
     * @param string $name Nombre del documento
     */
    public function __construct($name = 'excel-file')
    {
        $this->PHPExcel = new PHPExcel();
        $this->PHPExcel->getProperties()->setTitle($name);
        $this->title = $name;
    }

    /**
     * @return PHPExcel_DocumentProperties
     */
    public function getPropiedades()
    {
        return $this->PHPExcel->getProperties();
    }

    /**
     * Crea una instancia de PHPExcel_Worksheet asignando
     * el nombre de la variable $name
     *
     * @param string $name Nombre del espacio de trabajo
     * @param mixed $callback Función anónima
     * @return mixed
     */
    public function sheet($name, $callback = null)
    {
        if ($this->sheets === 0)
        {
            $sheet = $this->PHPExcel->getActiveSheet();
            $this->sheets++;
        }
        else
        {
            $sheet = $this->PHPExcel->createSheet($this->sheets);
            $this->sheets++;
        }

        $sheet->setTitle($name);

        if (!is_null($callback))
        {
            call_user_func($callback, $sheet);
        }

        return $sheet;
    }

    /**
     * Exporta el contenido a HTML
     */
    public function show()
    {
        $writer = new PHPExcel_Writer_HTML($this->PHPExcel);
        $writer->writeAllSheets();
        $writer->save('php://output');
    }

    /**
     * Permite descargar el archivo en 2 formatos
     * <ul>
     * <li>"xls" Compatible con excel 2003</li>
     * <li>"xlsx" Compatible con excel 2007 o superior</li>
     * <li>Por defecto exporta el archivo con la extension "xlsx"</li>
     * @param string $ext extension del archivo a descargar
     */
    public function download($ext = 'xlsx')
    {
        switch ($ext)
        {
            case 'xls':
                header("Content-Type:   application/vnd.ms-excel");
                header('Content-Disposition: attachment;filename="' . $this->getTitle() . '.xls"');
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Cache-Control: private", false);
                $writer = PHPExcel_IOFactory::createWriter($this->PHPExcel, 'Excel5');
                $writer->save('php://output');
                break;
            case 'xlsx':
            default:
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="' . $this->getTitle() . '.xlsx"');
                $writer = PHPExcel_IOFactory::createWriter($this->PHPExcel, 'Excel2007');
                $writer->save('php://output');
                break;
        }
    }

    /**
     * @return string Titulo del documento
     */
    public function getTitle()
    {
        return $this->title;
    }
}?>
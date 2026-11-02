<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;

class PdfGeneratorService
{
    protected $pdf;
    protected $config = [];
    protected $view;
    protected $data = [];

    public function __construct()
    {
        // Default configurations
        $this->config = [
            'orientation' => 'portrait', // portrait or landscape
            'paper_size' => 'a4',
            'title' => 'Documento PDF',
            'show_header' => true,
            'show_footer' => true,
            'font_family' => 'sans-serif',
            'font_size' => '12px',
            'margins' => [
                'top' => '2cm',
                'right' => '2cm',
                'bottom' => '2cm',
                'left' => '2cm',
            ],
            'background_image' => null,
            'background_opacity' => 0.1,
            'show_pagination' => true,
            'institution_name' => 'Universidad Nacional de Ingeniería',
            'logo_path' => null,
            'additional_info' => date('Y-m-d H:i:s'),
        ];
    }

    /**
     * Merge new configurations with defaults.
     *
     * @param array $config
     * @return $this
     */
    public function setConfig(array $config)
    {
        if (isset($config['margins']) && is_array($config['margins'])) {
            $this->config['margins'] = array_merge($this->config['margins'], $config['margins']);
            unset($config['margins']);
        }
        $this->config = array_merge($this->config, $config);
        return $this;
    }

    /**
     * Set the Blade view and data for the PDF content.
     *
     * @param string $view
     * @param array $data
     * @return $this
     */
    public function setView($view, $data = [])
    {
        $this->view = $view;
        $this->data = $data;
        return $this;
    }

    /**
     * Build the PDF instance.
     *
     * @return $this
     */
    public function generate()
    {
        if (!$this->view) {
            throw new \Exception("View not set for PDF Generator");
        }

        // Pass both data and config to the view
        $dataWithConfig = array_merge($this->data, ['pdfConfig' => $this->config]);
        
        $this->pdf = Pdf::loadView($this->view, $dataWithConfig)
            ->setPaper($this->config['paper_size'], $this->config['orientation']);
            
        // Optional: apply warnings or options like enable_remote, etc. if needed via facade options.
        // For example, $this->pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

        return $this;
    }

    /**
     * Stream the PDF to the browser.
     *
     * @param string $filename
     * @return \Illuminate\Http\Response
     */
    public function stream($filename = 'document.pdf')
    {
        return $this->pdf->stream($filename);
    }

    /**
     * Force download the PDF.
     *
     * @param string $filename
     * @return \Illuminate\Http\Response
     */
    public function download($filename = 'document.pdf')
    {
        return $this->pdf->download($filename);
    }
}

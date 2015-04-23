<?php

namespace App\Presenters;

use Nette,
    Nette\Application\UI,
    Nette\Application\Responses\FileResponse;

class GenerateCssPresenter extends BasePresenter
{

    const TEMP = 'temp';

    const CSS  = 'bowtie';

    const ZIP_NAME = 'gen_bowtie';

    const BOWTIE_VERSION = '1.0.0';


    private function getCSSPath($surfix){
        return self::TEMP . '/'. self::CSS . '_' . $surfix . ".css";
    }

    private function getZIPPath($surfix){
        return self::TEMP . '/' . self::ZIP_NAME . '_' . $surfix . '.zip';
    }

    private function getBowtieVersion(){
        if(is_file(__ROOT__ . '/composer.lock')){
            $string = file_get_contents(__ROOT__ . '/composer.lock');
            $json_a = json_decode($string, true);
            $packages = $json_a['packages'];

            foreach($packages as $package){
                if($package['name'] == 'me/bowtie'){
                    return $package['version'];
                }
            }
        }

        return null;
    }


    public function renderDefault($download = false, $zipSurfix)
    {
        if ($download){
            $httpResponse = $this->context->getService('httpResponse');
            $httpResponse->setHeader('Pragma', "public");
            $httpResponse->setHeader('Expires', 0);
            $httpResponse->setHeader('Cache-Control', "must-revalidate, post-check=0, pre-check=0");
            $httpResponse->setHeader('Content-Transfer-Encoding', "binary");
            $httpResponse->setHeader('Content-Description', "File Transfer");
            $httpResponse->setHeader('Content-Length', filesize($this->getZIPPath($zipSurfix)));
            $this->sendResponse(new FileResponse($this->getZIPPath($zipSurfix), 'gen_bowtie.zip', 'contenttype'));
        }
    }



    protected function createComponentGenerateCssForm()
    {
        $form = new UI\Form;
        global $tmp;

        for ($i = 1; $i <= 68; $i ++){
            $tmp = 'input' . $i;
            switch($i) {
                case ($i <= 31):
                    $form->addCheckbox($tmp);
                    break;
                case ($i == 48):
                    $form->addSelect($tmp, NULL, array('nonresp' => 'False', 'resp' => 'True'));
                    break;
                case ($i == 64):
                    $form->addSelect($tmp, NULL, array('sans_serif' => 'Font family, sans serif',
                        'serif' => 'Font family, serif', 'monospace' => 'Font family, monospace'));
                    break;
                default:
                    $form->addText($tmp);
            }
        }

        $form->addSubmit('send');
        $form->onSuccess[] = array($this, 'cssFormSubmitted');

        return $form;
    }



    public function cssFormSubmitted(UI\Form $form, $values)
    {
        $surfix = Nette\Utils\Random::generate(20);

        if ($form->isSuccess()) {
            $tmp = "";

            $string = array(
                " @import \"bowtie/less/alerts\";",
                "",
                " @import \"bowtie/less/awesome-menu\";",
                " @import \"bowtie/less/bna-widget\";",
                " @import \"bowtie/less/borders\";",
                " @import \"bowtie/less/buttons\";",
                "",
                " @import \"bowtie/less/dropdown\";",
                "",
                "",
                "",
                " @import \"bowtie/less/forms\";",
                " @import \"bowtie/less/harmonica\";",
                "",
                " @import \"bowtie/less/ios-checkbox\";",
                "",
                " @import \"bowtie/less/navbar\";",
                " @import \"bowtie/less/tabs\";",
                " @import \"bowtie/less/modals\";",
                " @import \"bowtie/less/tables\";",
                " @import \"bowtie/less/rating\";",
                " @import \"bowtie/less/tooltip\";",
                " @import \"bowtie/less/popover\";",
                "",
                " @import \"bowtie/less/slider\";",
                " @import \"bowtie/less/pagination\";",
                " @import \"bowtie/less/notifications\";",
                " @import \"bowtie/less/timeline\";",
                " @import \"bowtie/less/login-page\";",
                " @import \"bowtie/less/widget-box\";",
                "",
                " @color-primary: ",
                " @color-secondary: ",
                " @color-tertiary: ",
                " @color-info: ",
                " @color-success-: ",
                " @color-warning: ",
                " @color-danger: ",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                " @columns: ",
                "",
                " @column-padding-vertical: ",
                " @column-padding-horizontal: ",
                " @column-margin-vertical: ",
                " @column-margin-horizontal: ",
                " @brackpoint-mini: ",
                " @brackpoint-small: ",
                " @brackpoint-medium: ",
                " @brackpoint-large: ",
                " @brackpoint-xlarge: ",
                " @border-radius-small: ",
                " @border-radius-vertical: ",
                " @border-radius-large: ",
                " @font-size-base: ",
                "",
                "",
                "",
                "",
                " @font-family-sans-serif: ",
                " @font-family-serif: ",
                " @font-family-monospace: "
            );

            $tmp = $tmp . " @import \"bowtie/less/variables-default\";";
            $tmp = $tmp . " @import \"bowtie/less/checkbox-01\";";
            $tmp = $tmp . " @import \"bowtie/less/filter-checkbox\";";
            $tmp = $tmp . " @import \"bowtie/less/filter-radio\";";
            $tmp = $tmp . " @import \"bowtie/less/pre-code\";";
            $tmp = $tmp . " @import \"bowtie/less/administration\";";
            $tmp = $tmp . " @import \"bowtie/less/awesome-grid\";";
            $tmp = $tmp . " @import \"bowtie/less/spacing\";";
            $tmp = $tmp . " @import \"bowtie/less/font\";";

            for ($i = 1; $i <= 68; $i ++) {
                $value = 'input'.$i;
                switch($i){
                    case ($i <= 31):
                        if ($values->$value){
                            $tmp = $tmp . $string[$i-1];
                        }
                        break;
                    case ($i == 48):
                        switch($values->$value) {
                            case 'resp':
                                $tmp = $tmp . " @responsive: true;";
                                break;
                            case 'nonresp':
                                $tmp = $tmp . " @responsive: false;";
                        }
                        break;
                    case ($i == 64):
                        switch ($values->$value){
                            case 'sans_serif':
                                $tmp = $tmp . " @font-family-base: @font-family-sans-serif;";
                                break;
                            case 'serif':
                                $tmp = $tmp . " @font-family-base: @font-family-serif;";
                                break;
                            case 'monospace':
                                $tmp = $tmp . " @font-family-base: @font-family-monospace;";
                        }
                        break;
                    default:
                        if (!empty($values->$value)){
                            $tmp = $tmp . $string[$i-1] . $values->$value . ";";
                        }
                }
            }


            $options = array('compress'=>true);
            $parser = new \Less_Parser($options);
            $parser->parse($tmp);
            $css = $parser->getCss();

            $file = fopen($this->getCSSPath($surfix), "w");
            fwrite($file,
                '/*!
'.'* Bowtie ' . $this->getBowtieVersion() . ' (http://bowtiecss.com)
'.'* Copyright ' . date('Y') .' modernipodnikatel.cz
'.'* Licensed under MIT
'.'*/
');
            fwrite($file, $css);
            fclose($file);

            // create new zip file
            $zip = new \ZipArchive;
            $result = $zip->open( $this->getZIPPath($surfix), \ZipArchive::CREATE );

            if ($result) {
                $zip->addFile($this->getCSSPath($surfix), "src/css/bowtie.css");
                $zip->addFile("bowtie/index.html", "index.html");

                $zip->addFile("bowtie/fonts/tiecons/tiecons.eot", "src/fonts/tiecons/tiecons.eot");
                $zip->addFile("bowtie/fonts/tiecons/tiecons.woff", "src/fonts/tiecons/tiecons.woff");
                $zip->addFile("bowtie/fonts/tiecons/tiecons.svg", "src/fonts/tiecons/tiecons.svg");
                $zip->addFile("bowtie/fonts/tiecons/tiecons.ttf", "src/fonts/tiecons/tiecons.ttf");

                $zip->close();
            }
        }

        $download = true;
        $this->redirect('GenerateCss:default', $download, $surfix);
    }
}
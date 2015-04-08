<?php

namespace App\Presenters;

use Nette,
    Nette\Application\UI,
    Nette\Application\Responses\FileResponse;

class GenerateCssPresenter extends BasePresenter
{
    public function renderDefault($download = false)
    {
        if ($download){
            $httpResponse = $this->context->getService('httpResponse');
            $httpResponse->setHeader('Pragma', "public");
            $httpResponse->setHeader('Expires', 0);
            $httpResponse->setHeader('Cache-Control', "must-revalidate, post-check=0, pre-check=0");
            $httpResponse->setHeader('Content-Transfer-Encoding', "binary");
            $httpResponse->setHeader('Content-Description', "File Transfer");
            $httpResponse->setHeader('Content-Length', filesize('gen_bowtie.zip'));
            $this->sendResponse(new FileResponse('gen_bowtie.zip', 'gen_bowtie.zip', 'contenttype'));
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

    public function cssFormSubmitted($form, $values)
    {
        if ($form->isSuccess()) {
            $tmp = "";

            $string = array(
                " @import \"less/alerts\";",
                "",
                " @import \"less/awesome-menu\";",
                " @import \"less/bna-widget\";",
                " @import \"less/borders\";",
                " @import \"less/buttons\";",
                "",
                " @import \"less/dropdown\";",
                "",
                "",
                "",
                " @import \"less/forms\";",
                " @import \"less/harmonica\";",
                "",
                " @import \"less/ios-checkbox\";",
                "",
                " @import \"less/navbar\";",
                " @import \"less/tabs\";",
                " @import \"less/modals\";",
                " @import \"less/tables\";",
                " @import \"less/rating\";",
                " @import \"less/tooltip\";",
                " @import \"less/popover\";",
                "",
                " @import \"less/slider\";",
                " @import \"less/pagination\";",
                " @import \"less/notifications\";",
                " @import \"less/timeline\";",
                " @import \"less/login-page\";",
                " @import \"less/widget-box\";",
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

            $tmp = $tmp . " @import \"less/font-proxima-nova\";";
            $tmp = $tmp . " @import \"less/font-awesome\";";
            $tmp = $tmp . " @import \"less/variables-default\";";
            $tmp = $tmp . " @import \"less/checkbox-01\";";
            $tmp = $tmp . " @import \"less/filter-checkbox\";";
            $tmp = $tmp . " @import \"less/filter-radio\";";
            $tmp = $tmp . " @import \"less/pre-code\";";
            $tmp = $tmp . " @import \"less/administration\";";
            $tmp = $tmp . " @import \"less/awesome-grid\";";
            $tmp = $tmp . " @import \"less/spacing\";";
            $tmp = $tmp . " @import \"less/font\";";

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

            /*try{
                $parser = new \Less_Parser();
                $parser->parse($tmp);
                $css = $parser->getCss();
            }catch(\Exception $e){
                $error_message = $e->getMessage();
                //echo $error_message;
            }*/

            $options = array('compress'=>true);
            $parser = new \Less_Parser($options);
            $parser->parse($tmp);
            $css = $parser->getCss();

            $file = fopen("gen_bowtie/css/bowtie.css", "w");
            fwrite($file, $css);
            fclose($file);

            //dump($values);

            // create new zip file
            $zip = new \ZipArchive;
            $result = $zip->open('gen_bowtie.zip', \ZipArchive::CREATE);

            if ($result === true) {
                $zip->addFile("gen_bowtie/css/bowtie.css", "css/bowtie.css");
                $zip->addFile("gen_bowtie/index.html", "index.html");

                $zip->addFile("gen_bowtie/fonts/proxima/proxima-nova-alt-black.otf", "fonts/proxima/proxima-nova-alt-black.otf");
                $zip->addFile("gen_bowtie/fonts/proxima/proxima-nova-alt-bold.otf", "fonts/proxima/proxima-nova-alt-bold.otf");
                $zip->addFile("gen_bowtie/fonts/proxima/proxima-nova-alt-extrabold.otf", "fonts/proxima/proxima-nova-alt-extrabold.otf");
                $zip->addFile("gen_bowtie/fonts/proxima/proxima-nova-alt-light.otf", "fonts/proxima/proxima-nova-alt-light.otf");
                $zip->addFile("gen_bowtie/fonts/proxima/proxima-nova-alt-regular.otf", "fonts/proxima/proxima-nova-alt-regular.otf");
                $zip->addFile("gen_bowtie/fonts/proxima/proxima-nova-alt-semibold.otf", "fonts/proxima/proxima-nova-alt-semibold.otf");
                $zip->addFile("gen_bowtie/fonts/proxima/proxima-nova-alt-thin.otf", "fonts/proxima/proxima-nova-alt-thin.otf");

                $zip->addFile("gen_bowtie/fonts/proxima/proxima-nova-black.otf", "fonts/proxima/proxima-nova-black.otf");
                $zip->addFile("gen_bowtie/fonts/proxima/proxima-nova-bold.otf", "fonts/proxima/proxima-nova-bold.otf");
                $zip->addFile("gen_bowtie/fonts/proxima/proxima-nova-extrabold.otf", "fonts/proxima/proxima-nova-extrabold.otf");
                $zip->addFile("gen_bowtie/fonts/proxima/proxima-nova-light.otf", "fonts/proxima/proxima-nova-light.otf");
                $zip->addFile("gen_bowtie/fonts/proxima/proxima-nova-regular.otf", "fonts/proxima/proxima-nova-regular.otf");
                $zip->addFile("gen_bowtie/fonts/proxima/proxima-nova-semibold.otf", "fonts/proxima/proxima-nova-semibold.otf");
                $zip->addFile("gen_bowtie/fonts/proxima/proxima-nova-thin.otf", "fonts/proxima/proxima-nova-thin.otf");

                $zip->addFile("gen_bowtie/fonts/proxima/proxima-nova-scosf-black.otf", "fonts/proxima/proxima-nova-scosf-black.otf");
                $zip->addFile("gen_bowtie/fonts/proxima/proxima-nova-scosf-bold.otf", "fonts/proxima/proxima-nova-scosf-bold.otf");
                $zip->addFile("gen_bowtie/fonts/proxima/proxima-nova-scosf-extrabold.otf", "fonts/proxima/proxima-nova-scosf-extrabold.otf");
                $zip->addFile("gen_bowtie/fonts/proxima/proxima-nova-scosf-light.otf", "fonts/proxima/proxima-nova-scosf-light.otf");
                $zip->addFile("gen_bowtie/fonts/proxima/proxima-nova-scosf-regular.otf", "fonts/proxima/proxima-nova-scosf-regular.otf");
                $zip->addFile("gen_bowtie/fonts/proxima/proxima-nova-scosf-semibold.otf", "fonts/proxima/proxima-nova-scosf-semibold.otf");
                $zip->addFile("gen_bowtie/fonts/proxima/proxima-nova-scosf-thin.otf", "fonts/proxima/proxima-nova-scosf-thin.otf");

                $zip->addFile("gen_bowtie/fonts/tiecons/tiecons.eot", "fonts/tiecons/tiecons.eot");
                $zip->addFile("gen_bowtie/fonts/tiecons/tiecons.woff", "fonts/tiecons/tiecons.woff");
                $zip->addFile("gen_bowtie/fonts/tiecons/tiecons.svg", "fonts/tiecons/tiecons.svg");
                $zip->addFile("gen_bowtie/fonts/tiecons/tiecons.ttf", "fonts/tiecons/tiecons.ttf");

                $zip->close();
            }
        }

        $download = true;
        $this->redirect('GenerateCss:default', $download);
    }
}
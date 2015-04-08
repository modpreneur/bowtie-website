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

        $form->addCheckbox('Option01');
        $form->addCheckbox('Option02');
        $form->addCheckbox('Option03');
        $form->addCheckbox('Option04');
        $form->addCheckbox('Option05');
        $form->addCheckbox('Option06');
        $form->addCheckbox('Option07');
        $form->addCheckbox('Option08');
        $form->addCheckbox('Option09');
        $form->addCheckbox('Option10');
        $form->addCheckbox('Option11');
        $form->addCheckbox('Option12');
        $form->addCheckbox('Option13');
        $form->addCheckbox('Option14');
        $form->addCheckbox('Option15');
        $form->addCheckbox('Option16');
        $form->addCheckbox('Option17');
        $form->addCheckbox('Option18');
        $form->addCheckbox('Option19');
        $form->addCheckbox('Option20');
        $form->addCheckbox('Option21');
        $form->addCheckbox('Option22');
        $form->addCheckbox('Option23');
        $form->addCheckbox('Option24');
        $form->addCheckbox('Option25');
        $form->addCheckbox('Option26');
        $form->addCheckbox('Option27');
        $form->addCheckbox('Option28');
        $form->addCheckbox('Option29');
        $form->addCheckbox('Option30');
        $form->addCheckbox('Option31');

        $form->addText('color1');
        $form->addText('color2');
        $form->addText('color3');

        $form->addText('color4');
        $form->addText('color5');
        $form->addText('color6');
        $form->addText('color7');

        $form->addText('color8');
        $form->addText('color9');
        $form->addText('color10');
        $form->addText('color11');
        $form->addText('color12');
        $form->addText('color13');
        $form->addText('color14');
        $form->addText('color15');

        $form->addText('shoesize');

        $form->addSelect('resp_columns', NULL, array('nonresp' => 'False', 'resp' => 'True'));

        $form->addText('padding1');
        $form->addText('padding2');
        $form->addText('margin1');
        $form->addText('margin2');

        $form->addText('brackpoint1');
        $form->addText('brackpoint2');
        $form->addText('brackpoint3');
        $form->addText('brackpoint4');
        $form->addText('brackpoint5');

        $form->addText('radius1');
        $form->addText('radius2');
        $form->addText('radius3');

        $form->addText('fontsize');
        $form->addText('hlineheight');
        $form->addText('blineheight');

        $form->addSelect('selectfontfamily', NULL, array('sans_serif' => 'Font family, sans serif',
            'serif' => 'Font family, serif', 'monospace' => 'Font family, monospace'));

        $form->addText('fontfamilybase');
        $form->addText('sansserif');
        $form->addText('serif');
        $form->addText('monospace');

        $form->addSubmit('send');

        $form->onSuccess[] = array($this, 'cssFormSubmitted');

        return $form;
    }

    public function cssFormSubmitted($form, $values)
    {
        if ($form->isSuccess()) {
            global $tmp;

            // Modules
            $tmp = $tmp . " @import \"less/font-proxima-nova\";";
            $tmp = $tmp . " @import \"less/font-awesome\";";
            $tmp = $tmp . " @import \"less/variables-default\";";
            //$parser->parse("@import \"variables\";");

            // Colours, fonts, etc.
            if (!empty($values->color1)) {
                $tmp = $tmp . " @color-primary: " . $values->color1 . ";";
            }
            if (!empty($values->color2)) {
                $tmp = $tmp . " @color-secondary: " . $values->color2 . ";";
            }
            if (!empty($values->color3)) {
                $tmp = $tmp . " @color-tertiary: " . $values->color3 . ";";
            }
            if (!empty($values->color4)) {
                $tmp = $tmp . " @color-info: " . $values->color4 . ";";
            }
            if (!empty($values->color5)) {
                $tmp = $tmp . " @color-success-: " . $values->color5 . ";";
            }
            if (!empty($values->color6)) {
                $tmp = $tmp . " @color-warning: " . $values->color6 . ";";
            }
            if (!empty($values->color7)) {
                $tmp = $tmp . " @color-danger: " . $values->color7 . ";";
            }
            if (!empty($values->shoesize)) {
                $tmp = $tmp . " @columns: " . $values->shoesize . ";";
            }
            switch($values->resp_columns)
            {
                case 'resp':
                    $tmp = $tmp . " @responsive: true;";
                    break;
                case 'nonresp':
                    $tmp = $tmp . " @responsive: false;";
            }

            // Paddings
            if (!empty($values->padding1)) {
                $tmp = $tmp . " @column-padding-vertical: " . $values->padding1 . ";";
            }
            if (!empty($values->padding2)) {
                $tmp = $tmp . " @column-padding-horizontal: " . $values->padding2 . ";";
            }

            // Margins
            if (!empty($values->margin1)) {
                $tmp = $tmp . " @column-margin-vertical: " . $values->margin1 . ";";
            }
            if (!empty($values->margin2)) {
                $tmp = $tmp . " @column-margin-horizontal: " . $values->margin2 . ";";
            }

            // Brackpoints
            if (!empty($values->brackpoint1)) {
                $tmp = $tmp . " @brackpoint-mini: " . $values->brackpoint1 . ";";
            }
            if (!empty($values->brackpoint2)) {
                $tmp = $tmp . " @brackpoint-small: " . $values->brackpoint2 . ";";
            }
            if (!empty($values->brackpoint3)) {
                $tmp = $tmp . " @brackpoint-medium: " . $values->brackpoint3 . ";";
            }
            if (!empty($values->brackpoint4)) {
                $tmp = $tmp . " @brackpoint-large: " . $values->brackpoint4 . ";";
            }
            if (!empty($values->brackpoint5)) {
                $tmp = $tmp . " @brackpoint-xlarge: " . $values->brackpoint5 . ";";
            }

            // Border radius
            if (!empty($values->radius1)) {
                $tmp = $tmp . " @border-radius-small: " . $values->radius1 . ";";
            }
            if (!empty($values->radius2)) {
                $tmp = $tmp . " @column-radius-vertical: " . $values->radius2 . ";";
            }
            if (!empty($values->radius3)) {
                $tmp = $tmp . " @border-radius-large: " . $values->radius3 . ";";
            }

            // Font size base
            if (!empty($values->fontsize)) {
                $tmp = $tmp . " @font-size-base: " . $values->fontsize . ";";
            }

            // Font family base
            switch ($values->fontfamilybase){
                case 'sans_serif':
                    $tmp = $tmp . " @font-family-base: @font-family-sans-serif;";
                    break;
                case 'serif':
                    $tmp = $tmp . " @font-family-base: @font-family-serif;";
                    break;
                case 'monospace':
                    $tmp = $tmp . " @font-family-base: @font-family-monospace;";
            }
            if (!empty($values->sansserif)) {
                $tmp = $tmp . " @font-family-sans-serif: " . $values->sansserif . ";";
            }
            if (!empty($values->serif)) {
                $tmp = $tmp . " @font-family-serif: " . $values->serif . ";";
            }
            if (!empty($values->monospace)) {
                $tmp = $tmp . " @font-family-monospace: " . $values->monospace . ";";
            }

            // Modules
            $tmp = $tmp . " @import \"less/awesome-grid\";";
            $tmp = $tmp . " @import \"less/spacing\";";
            $tmp = $tmp . " @import \"less/font\";";

            if ($values->Option01) {
                $tmp = $tmp . " @import \"less/alerts\";";
            }
            if ($values->Option05) {
                $tmp = $tmp . " @import \"less/borders\";";
            }
            if ($values->Option06) {
                $tmp = $tmp . " @import \"less/buttons\";";
            }
            if ($values->Option17) {
                $tmp = $tmp . " @import \"less/navbar\";";
            }
            if ($values->Option18) {
                $tmp = $tmp . " @import \"less/tabs\";";
            }
            if ($values->Option19) {
                $tmp = $tmp . " @import \"less/modals\";";
            }
            /*if ($values->Option03) {
                $parser->parse("//@import \"menu\";");
            }*/
            if ($values->Option08) {
                $tmp = $tmp . " @import \"less/dropdown\";";
            }
            if ($values->Option20) {
                $tmp = $tmp . " @import \"less/tables\";";
            }
            if ($values->Option15) {
                $tmp = $tmp . " @import \"less/ios-checkbox\";";
            }
            //if ($values->Option15) { //?
            $tmp = $tmp . " @import \"less/checkbox-01\";";
            //}
            if ($values->Option21) {
                $tmp = $tmp . " @import \"less/rating\";";
            }
            //if ($values->Option21) {//?
            $tmp = $tmp . " @import \"less/filter-checkbox\";";
            //}
            //if ($values->Option21) {//?
            $tmp = $tmp . " @import \"less/filter-radio\";";
            //}
            if ($values->Option04) {
                $tmp = $tmp . " @import \"less/bna-widget\";";
            }
            //if ($values->Option04) { //nope
            $tmp = $tmp . " @import \"less/pre-code\";";
            //}
            if ($values->Option22) {
                $tmp = $tmp . " @import \"less/tooltip\";";
            }
            if ($values->Option25) {
                $tmp = $tmp . " @import \"less/slider\";";
            }
            if ($values->Option23) {
                $tmp = $tmp . " @import \"less/popover\";";
            }
            //if ($values->Option23) {
            $tmp = $tmp . " @import \"less/administration\";";
            //}
            if ($values->Option03) { //2x
                $tmp = $tmp . " @import \"less/awesome-menu\";";
            }
            if ($values->Option29) {
                $tmp = $tmp . " @import \"less/login-page\";";
            }
            if ($values->Option26) {
                $tmp = $tmp . " @import \"less/pagination\";";
            }
            if ($values->Option12) {
                $tmp = $tmp . " @import \"less/forms\";";
            }
            if ($values->Option30) {
                $tmp = $tmp . " @import \"less/widget-box\";";
            }
            if ($values->Option27) {
                $tmp = $tmp . " @import \"less/notifications\";";
            }
            if ($values->Option28) {
                $tmp = $tmp . " @import \"less/timeline\";";
            }
            if ($values->Option13) {
                $tmp = $tmp . " @import \"less/harmonica\";";
            }

            //$abs_url = '__DIR__' . 'DIRECTORY_SEPARATOR' . 'www' . 'DIRECTORY_SEPARATOR' . 'less';
            //$url = 'www' . 'DIRECTORY_SEPARATOR' . 'less';
            //$directories = array( $abs_url => $url );
            //$parser->SetImportDirs($directories);

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

            // create zip file
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
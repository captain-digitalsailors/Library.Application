<?php

namespace Com\PaulDevelop\Library\Application;

define('APP_FS_CONTROLLER', 'path/to/controller/');
define('APP_FS_TEMPLATE', 'path/to/templates/');

/*
class MyRequestHandler extends RequestHandler
{
    public function __construct()
    {
        $this->_urlMapper = new UrlToFileMapper(
            'Com\PaulDevelop\Library',
            '/home/vagrant/project/test/assets/src/template/frontend/',
            '/home/vagrant/project/test/assets/src/controller/frontend/'
        );
        $this->_urlMapper->RegisterFileNotFoundCallback(
            function (Request $request = null) {
                //header('Location: '.FRONTEND_URL_BASE);
                echo 'FileNotFound';
            }
        );
    }

    public function OnRequestHandled($app = null)
    {
        $this->_urlMapper->RegisterSetupTemplateCallback(
            function (Request $request = null, ITemplate $template = null) {
                return null;
            }
        );

        $this->_urlMapper->RegisterRenderTemplateFileNameCallback(
            function (Request $request = null) {
                return null;
            }
        );

        $this->_urlMapper->RegisterRenderControllerFileNameCallback(
            function (Request $request = null) {
                return null;
            }
        );

        $this->_urlMapper->RegisterRenderControllerClassNameCallback(
            function (Request $request = null) {
                return null;
            }
        );

        parent::OnRequestHandled($app);
    }
}
*/

use Com\PaulDevelop\Library\Common\Base;
use Com\PaulDevelop\Library\Common\ITemplate;

class MyTemplate extends Base implements ITemplate {
    private $templateFileName = '';

    /**
     * @return string
     */
    public function process()
    {
        // TODO: Implement process() method.
        //echo 'Template Content'.PHP_EOL;
        //var_dump($this->TemplateFileName);
    }

    public function setTemplateFileName($templateFileName = '')
    {
        $this->templateFileName = $templateFileName;
    }

    public function getTemplateFileName()
    {
        return $this->templateFileName;
    }

    public function bindVariable($variableName = '', $content = null)
    {
        // TODO: Implement bindVariable() method.
    }
}

class MyRequestInputBackendFolder extends Base implements IRequestInput {
    public function getMethod()
    {
        return 'GET';
    }

    public function getProtocol()
    {
        return 'http';
    }

    public function getSubdomains()
    {
        return '';
    }

    public function getDomain()
    {
        return 'pauldevelop.com';
    }

    public function getPort()
    {
        return '81';
    }

    public function getPath()
    {
        return 'backend/user/edit/id-1/';
    }

    public function getFormat()
    {
        return 'text/html';
    }
}

class MyRequestInputBackendSubdomain extends Base implements IRequestInput {
    public function getMethod()
    {
        return 'GET';
    }

    public function getProtocol()
    {
        return 'http';
    }

    public function getSubdomains()
    {
        return 'backend';
    }

    public function getDomain()
    {
        return 'pauldevelop.com';
    }

    public function getPort()
    {
        return '81';
    }

    public function getPath()
    {
        return 'user/edit/id-1/';
    }

    public function getFormat()
    {
        return 'text/html';
    }
}

class MyRequestInputRegexPattern extends Base implements IRequestInput {
    public function getMethod()
    {
        return 'GET';
    }

    public function getProtocol()
    {
        return 'http';
    }

    public function getSubdomains()
    {
        return '';
    }

    public function getDomain()
    {
        return 'pauldevelop.com';
    }

    public function getPort()
    {
        return '81';
    }

    public function getPath()
    {
        return '5r6n9a-Tiere-im-Urlaub';
    }

    public function getFormat()
    {
        return 'text/html';
    }
}

class MyRequestInputRegexPatternController implements IController {

    /**
     * @param Request   $request
     * @param ITemplate $template
     *
     * @return string
     */
    public function process(Request $request = null, ITemplate $template = null)
    {
        return 'regex pattern controller';
    }
}

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testMappingBackendFolder()
    {
/*
//        $baseObj = new BaseObject();
//        $this->assertEquals('property value', $baseObj->Property);
        $requestHandler = new RequestHandler();

        $application = new Application();
        $application->registerRequestProcessedEvent(
            $requestHandler,
            'OnRequestHandled'
        );

        $parameter = array();
        $application->processRequest(null, $parameter);


        //$request = $application->Request;
        //var_dump($request);
*/
        //echo "FOLDER".PHP_EOL;
        $mapper = new UrlToFileMapper();
        $mapper->mapFolder(
            '^pauldevelop\.com:81\/backend\/',
            array('De\Welt\JobPortal'),
            'Controller\Backend',
            APP_FS_CONTROLLER.'',
            APP_FS_TEMPLATE.'backend'
        );
        //$mapper->mapFolder(
        //    'pauldevelop.com.info/*',
        //    'De\Welt\JobPortal\Controller\Frontend',
        //    APP_FS_CONTROLLER.'',
        //    APP_FS_TEMPLATE.'frontend'
        //);
        //$ri = new MyRequestInput();
        //var_dump($ri->Path);die;

        $rp = new RequestParser(new Sanitizer(), new Validator());
        $request = $rp->parse(new MyRequestInputBackendFolder());

        $template = new MyTemplate();

        $output = $mapper->process($request, $template);
        //var_dump($template->TemplateFileName);
        //echo $output;
        //die;
        //echo $template->TemplateFileName;

        $this->assertEquals('path/to/templates/backend/html.user.edit.template.pdt', $template->TemplateFileName);
    }

    /**
     * @test
     */
    public function testMappingBackendSubdomain()
    {
        //echo "SUBDOMAIN".PHP_EOL;
        $mapper = new UrlToFileMapper();
        $mapper->mapFolder(
            '^backend\.pauldevelop\.com:81\/*',
            array('De\Welt\JobPortal'),
            'Controller\Backend',
            APP_FS_CONTROLLER.'',
            APP_FS_TEMPLATE.'backend'
        );
        $rp = new RequestParser(new Sanitizer(), new Validator());
        //$request = $rp->parse(new MyRequestInputBackendFolder());
        $request = $rp->parse(new MyRequestInputBackendSubdomain());

        $template = new MyTemplate();

        $output = $mapper->process($request, $template);
        //var_dump($template->TemplateFileName);
        //die;
        $this->assertEquals('path/to/templates/backend/html.user.edit.template.pdt', $template->TemplateFileName);
    }

    /**
     * @test
     */
    public function testMappingRegexPattern()
    {
        //echo "SUBDOMAIN".PHP_EOL;
        $mapper = new UrlToFileMapper();
        $mapper->mapClass(
            '^pauldevelop\.com:81\/[a-z0-9]{6}.*?',
            new MyRequestInputRegexPatternController()
        );
        $rp = new RequestParser(new Sanitizer(), new Validator());
        //$request = $rp->parse(new MyRequestInputBackendFolder());
        $request = $rp->parse(new MyRequestInputRegexPattern(), false);
//var_dump($request);die;
        $template = new MyTemplate();

        $output = $mapper->process($request, $template);
        $this->assertEquals('regex pattern controller', $output);
        //var_dump($template->TemplateFileName);
        //die;
        //$this->assertEquals('path/to/templates/backend/html.user.edit.template.pdt', $template->TemplateFileName);
    }
}

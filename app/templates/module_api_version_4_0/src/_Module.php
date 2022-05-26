<?php
/**
 * <%- pluginName %> module for Craft CMS 3.x
 *
 * <%- pluginDescription %>
 *
 * @link      <%= pluginAuthorUrl %>
 * @copyright <%- copyrightNotice %>
 */

namespace modules\<%= pluginDirName %>;

use modules\<%= pluginDirName%>\assetbundles\<%= pluginDirName %>\<%= pluginHandle %>Asset;
<% if (pluginComponents.indexOf('services') >= 0){ -%>
<% var services = serviceName -%>
<% if ((typeof(services[0]) !== 'undefined') && (services[0] !== "")) { -%>
<% services.forEach(function(service, index, array){ -%>
use modules\<%= pluginDirName%>\services\<%= service %> as <%= service %>Service;
<% }); -%>
<% } -%>
<% } -%>
<% if (pluginComponents.indexOf('variables') >= 0){ -%>
use modules\<%= pluginDirName %>\variables\<%= pluginHandle %>Variable;
<% } -%>
<% if (pluginComponents.indexOf('twigextensions') >= 0){ -%>
use modules\<%= pluginDirName%>\twigextensions\<%= pluginHandle %>TwigExtension;
<% } -%>
<% if (pluginComponents.indexOf('elementtypes') >= 0){ -%>
<% var elements = elementName -%>
<% if ((typeof(elements[0]) !== 'undefined') && (elements[0] !== "")) { -%>
<% elements.forEach(function(element, index, array){ -%>
use modules\<%= pluginDirName%>\elements\<%= element %> as <%= element %>Element;
<% }); -%>
<% } -%>
<% } -%>
<% if (pluginComponents.indexOf('fieldtypes') >= 0){ -%>
<% var fields = fieldName -%>
<% if ((typeof(fields[0]) !== 'undefined') && (fields[0] !== "")) { -%>
<% fields.forEach(function(field, index, array){ -%>
use modules\<%= pluginDirName%>\fields\<%= field %> as <%= field %>Field;
<% }); -%>
<% } -%>
<% } -%>
<% if (pluginComponents.indexOf('utilities') >= 0){ -%>
<% var utilities = utilityName -%>
<% if ((typeof(utilities[0]) !== 'undefined') && (utilities[0] !== "")) { -%>
<% utilities.forEach(function(utility, index, array){ -%>
use modules\<%= pluginDirName%>\utilities\<%= utility %> as <%= utility %>Utility;
<% }); -%>
<% } -%>
<% } -%>
<% if (pluginComponents.indexOf('widgets') >= 0){ -%>
<% var widgets = widgetName -%>
<% if ((typeof(widgets[0]) !== 'undefined') && (widgets[0] !== "")) { -%>
<% widgets.forEach(function(widget, index, array){ -%>
use modules\<%= pluginDirName%>\widgets\<%= widget %> as <%= widget %>Widget;
<% }); -%>
<% } -%>
<% } -%>

<% var includeRegisterComponentTypesEvent = false -%>
<% var includeRegisterUrlRulesEvent = false -%>
use Craft;
use craft\events\RegisterTemplateRootsEvent;
use craft\events\TemplateEvent;
use craft\i18n\PhpMessageSource;
use craft\web\View;
<% if (pluginComponents.indexOf('consolecommands') >= 0){ -%>
use craft\console\Application as ConsoleApplication;
<% } -%>
<% if (pluginComponents.indexOf('controllers') >= 0){ -%>
<% includeRegisterUrlRulesEvent = true -%>
use craft\web\UrlManager;
<% } -%>
<% if (pluginComponents.indexOf('elementtypes') >= 0){ -%>
<% includeRegisterComponentTypesEvent = true -%>
use craft\services\Elements;
<% } -%>
<% if (pluginComponents.indexOf('fieldtypes') >= 0){ -%>
<% includeRegisterComponentTypesEvent = true -%>
use craft\services\Fields;
<% } -%>
<% if (pluginComponents.indexOf('utilities') >= 0){ -%>
<% includeRegisterComponentTypesEvent = true -%>
use craft\services\Utilities;
<% } -%>
<% if (pluginComponents.indexOf('variables') >= 0){ -%>
use craft\web\twig\variables\CraftVariable;
<% } -%>
<% if (pluginComponents.indexOf('widgets') >= 0){ -%>
<% includeRegisterComponentTypesEvent = true -%>
use craft\services\Dashboard;
<% } -%>
<% if (includeRegisterComponentTypesEvent === true){ -%>
use craft\events\RegisterComponentTypesEvent;
<% } -%>
<% if (includeRegisterUrlRulesEvent === true){ -%>
use craft\events\RegisterUrlRulesEvent;
<% } -%>

use yii\base\Event;
use yii\base\InvalidConfigException;
use yii\base\Module;

<% if ((typeof codeComments !== 'undefined') && (codeComments)) { -%>
/**
 * Craft plugins are very much like little applications in and of themselves. We’ve made
 * it as simple as we can, but the training wheels are off. A little prior knowledge is
 * going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
 * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
 *
 * @author    <%- pluginAuthorName %>
 * @package   <%= pluginHandle %>
 * @since     <%= pluginVersion %>
 *
<% if (pluginComponents.indexOf('services') >= 0){ -%>
<% var services = serviceName -%>
<% if ((typeof(services[0]) !== 'undefined') && (services[0] !== "")) { -%>
<% services.forEach(function(service, index, array){ -%>
 * @property  <%= service %>Service $<%= service[0].toLowerCase() + service.slice(1) %>
<% }); -%>
<% } -%>
<% } -%>
 */
<% } else { -%>
/**
 * Class <%= pluginHandle %>
 *
 * @author    <%- pluginAuthorName %>
 * @package   <%= pluginHandle %>
 * @since     <%= pluginVersion %>
 *
<% if (pluginComponents.indexOf('services') >= 0){ -%>
<% var services = serviceName -%>
<% if ((typeof(services[0]) !== 'undefined') && (services[0] !== "")) { -%>
<% services.forEach(function(service, index, array){ -%>
 * @property  <%= service %>Service $<%= service[0].toLowerCase() + service.slice(1) %>
<% }); -%>
<% } -%>
<% } -%>
 */
<% } -%>
class <%= pluginHandle %> extends Module
{
    // Static Properties
    // =========================================================================

<% if ((typeof codeComments !== 'undefined') && (codeComments)) { -%>
    /**
     * Static property that is an instance of this module class so that it can be accessed via
     * <%= pluginHandle %>::$instance
     *
     * @var <%= pluginHandle %>
     */
<% } else { -%>
    /**
     * @var <%= pluginHandle %>
     */
<% } -%>
    public static $instance;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, array $config = [])
    {
        Craft::setAlias('@modules/<%= pluginDirName %>', $this->getBasePath());
        $this->controllerNamespace = 'modules\<%= pluginDirName %>\controllers';

        // Translation category
        $i18n = Craft::$app->getI18n();
        /** @noinspection UnSafeIsSetOverArrayInspection */
        if (!isset($i18n->translations[$id]) && !isset($i18n->translations[$id.'*'])) {
            $i18n->translations[$id] = [
                'class' => PhpMessageSource::class,
                'sourceLanguage' => 'en-US',
                'basePath' => '@modules/<%= pluginDirName %>/translations',
                'forceTranslation' => true,
                'allowOverrides' => true,
            ];
        }

        // Base template directory
        Event::on(View::class, View::EVENT_REGISTER_CP_TEMPLATE_ROOTS, function (RegisterTemplateRootsEvent $e) {
            if (is_dir($baseDir = $this->getBasePath().DIRECTORY_SEPARATOR.'templates')) {
                $e->roots[$this->id] = $baseDir;
            }
        });

        // Set this as the global instance of this module class
        static::setInstance($this);

        parent::__construct($id, $parent, $config);
    }

 <% if ((typeof codeComments !== 'undefined') && (codeComments)) { -%>
   /**
     * Set our $instance static property to this class so that it can be accessed via
     * <%= pluginHandle %>::$instance
     *
     * Called after the module class is instantiated; do any one-time initialization
     * here such as hooks and events.
     *
     * If you have a '/vendor/autoload.php' file, it will be loaded for you automatically;
     * you do not need to load it in your init() method.
     *
     */
<% } else { -%>
   /**
     * @inheritdoc
     */
<% } -%>
    public function init()
    {
        parent::init();
        self::$instance = $this;

<% if ((typeof codeComments !== 'undefined') && (codeComments)){ -%>
        // Load our AssetBundle
<% } -%>
        if (Craft::$app->getRequest()->getIsCpRequest()) {
            Event::on(
                View::class,
                View::EVENT_BEFORE_RENDER_TEMPLATE,
                function (TemplateEvent $event) {
                    try {
                        Craft::$app->getView()->registerAssetBundle(<%= pluginHandle %>Asset::class);
                    } catch (InvalidConfigException $e) {
                        Craft::error(
                            'Error registering AssetBundle - '.$e->getMessage(),
                            __METHOD__
                        );
                    }
                }
            );
        }
<% if (pluginComponents.indexOf('twigextensions') >= 0){ -%>

<% if ((typeof codeComments !== 'undefined') && (codeComments)){ -%>
        // Add in our Twig extensions
<% } -%>
        Craft::$app->view->registerTwigExtension(new <%= pluginHandle %>TwigExtension());
<% } -%>
<% if (pluginComponents.indexOf('consolecommands') >= 0){ -%>

<% if ((typeof codeComments !== 'undefined') && (codeComments)){ -%>
        // Add in our console commands
<% } -%>
        if (Craft::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'modules\<%= pluginDirName %>\console\controllers';
        }
<% } -%>
<% if (pluginComponents.indexOf('controllers') >= 0){ -%>

<% if ((typeof codeComments !== 'undefined') && (codeComments)){ -%>
        // Register our site routes
<% } -%>
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
<% var controllers = controllerName -%>
<% if ((typeof(controllers[0]) !== 'undefined') && (controllers[0] !== "")) { -%>
<% controllers.forEach(function(controller, index, array){ -%>
                $event->rules['siteActionTrigger<%= index + 1 %>'] = '<%= pluginKebabHandle %>/<%= controller.replace(/([A-Z])/g, function($1){return "-"+$1.toLowerCase();}).slice(1) %>';
<% }); -%>
<% } -%>
            }
        );

<% if ((typeof codeComments !== 'undefined') && (codeComments)){ -%>
        // Register our CP routes
<% } -%>
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
<% var controllers = controllerName -%>
<% if ((typeof(controllers[0]) !== 'undefined') && (controllers[0] !== "")) { -%>
<% controllers.forEach(function(controller, index, array){ -%>
                $event->rules['cpActionTrigger<%= index + 1 %>'] = '<%= pluginKebabHandle %>/<%= controller.replace(/([A-Z])/g, function($1){return "-"+$1.toLowerCase();}).slice(1) %>/do-something';
<% }); -%>
<% } -%>
            }
        );
<% } -%>
<% if (pluginComponents.indexOf('elementtypes') >= 0){ -%>

<% if ((typeof codeComments !== 'undefined') && (codeComments)){ -%>
        // Register our elements
<% } -%>
        Event::on(
            Elements::class,
            Elements::EVENT_REGISTER_ELEMENT_TYPES,
            function (RegisterComponentTypesEvent $event) {
<% var elements = elementName -%>
<% if ((typeof(elements[0]) !== 'undefined') && (elements[0] !== "")) { -%>
<% elements.forEach(function(element, index, array){ -%>
                $event->types[] = <%= element %>Element::class;
<% }); -%>
<% } -%>
            }
        );
<% } -%>
<% if (pluginComponents.indexOf('fieldtypes') >= 0){ -%>

<% if ((typeof codeComments !== 'undefined') && (codeComments)){ -%>
        // Register our fields
<% } -%>
        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
<% var fields = fieldName -%>
<% if ((typeof(fields[0]) !== 'undefined') && (fields[0] !== "")) { -%>
<% fields.forEach(function(field, index, array){ -%>
                $event->types[] = <%= field %>Field::class;
<% }); -%>
<% } -%>
            }
        );
<% } -%>
<% if (pluginComponents.indexOf('utilities') >= 0){ -%>

<% if ((typeof codeComments !== 'undefined') && (codeComments)){ -%>
        // Register our utilities
<% } -%>
        Event::on(
            Utilities::class,
            Utilities::EVENT_REGISTER_UTILITY_TYPES,
            function (RegisterComponentTypesEvent $event) {
<% var utilities = utilityName -%>
<% if ((typeof(utilities[0]) !== 'undefined') && (utilities[0] !== "")) { -%>
<% utilities.forEach(function(utility, index, array){ -%>
                $event->types[] = <%= utility %>Utility::class;
<% }); -%>
<% } -%>
            }
        );
<% } -%>
<% if (pluginComponents.indexOf('widgets') >= 0){ -%>

<% if ((typeof codeComments !== 'undefined') && (codeComments)){ -%>
        // Register our widgets
<% } -%>
        Event::on(
            Dashboard::class,
            Dashboard::EVENT_REGISTER_WIDGET_TYPES,
            function (RegisterComponentTypesEvent $event) {
<% var widgets = widgetName -%>
<% if ((typeof(widgets[0]) !== 'undefined') && (widgets[0] !== "")) { -%>
<% widgets.forEach(function(widget, index, array){ -%>
                $event->types[] = <%= widget %>Widget::class;
<% }); -%>
<% } -%>
            }
        );
<% } -%>
<% if (pluginComponents.indexOf('variables') >= 0){ -%>

<% if ((typeof codeComments !== 'undefined') && (codeComments)){ -%>
        // Register our variables
<% } -%>
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('<%= pluginCamelHandle %>', <%= pluginHandle %>Variable::class);
            }
        );
<% } -%>

<% if ((typeof codeComments !== 'undefined') && (codeComments)) { -%>
/**
 * Logging in Craft involves using one of the following methods:
 *
 * Craft::trace(): record a message to trace how a piece of code runs. This is mainly for development use.
 * Craft::info(): record a message that conveys some useful information.
 * Craft::warning(): record a warning message that indicates something unexpected has happened.
 * Craft::error(): record a fatal error that should be investigated as soon as possible.
 *
 * Unless `devMode` is on, only Craft::warning() & Craft::error() will log to `craft/storage/logs/web.log`
 *
 * It's recommended that you pass in the magic constant `__METHOD__` as the second parameter, which sets
 * the category to the method (prefixed with the fully qualified class name) where the constant appears.
 *
 * To enable the Yii debug toolbar, go to your user account in the AdminCP and check the
 * [] Show the debug toolbar on the front end & [] Show the debug toolbar on the Control Panel
 *
 * http://www.yiiframework.com/doc-2.0/guide-runtime-logging.html
 */
<% } else { -%>
<% } -%>
        Craft::info(
            Craft::t(
                '<%= pluginKebabHandle %>',
                '{name} module loaded',
                ['name' => '<%- pluginName %>']
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================
}

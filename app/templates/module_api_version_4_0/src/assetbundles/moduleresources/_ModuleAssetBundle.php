<?php
/**
 * <%- pluginName %> module for Craft CMS 3.x
 *
 * <%- pluginDescription %>
 *
 * @link      <%= pluginAuthorUrl %>
 * @copyright <%- copyrightNotice %>
 */

namespace modules\<%= pluginDirName %>\assetbundles\<%= pluginHandle.toLowerCase() %>;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

<% if ((typeof codeComments !== 'undefined') && (codeComments)) { -%>
/**
 * <%= pluginHandle %>Asset AssetBundle
 *
 * AssetBundle represents a collection of asset files, such as CSS, JS, images.
 *
 * Each asset bundle has a unique name that globally identifies it among all asset bundles used in an application.
 * The name is the [fully qualified class name](http://php.net/manual/en/language.namespaces.rules.php)
 * of the class representing it.
 *
 * An asset bundle can depend on other asset bundles. When registering an asset bundle
 * with a view, all its dependent asset bundles will be automatically registered.
 *
 * http://www.yiiframework.com/doc-2.0/guide-structure-assets.html
 *
 * @author    <%- pluginAuthorName %>
 * @package   <%= pluginHandle %>
 * @since     <%= pluginVersion %>
 */
<% } else { -%>
/**
 * @author    <%- pluginAuthorName %>
 * @package   <%= pluginHandle %>
 * @since     <%= pluginVersion %>
 */
<% } -%>
class <%= pluginHandle %>Asset extends AssetBundle
{
    // Public Methods
    // =========================================================================

<% if ((typeof codeComments !== 'undefined') && (codeComments)) { -%>
    /**
     * Initializes the bundle.
     */
<% } else { -%>
    /**
     * @inheritdoc
     */
<% } -%>
    public function init()
    {
<% if ((typeof codeComments !== 'undefined') && (codeComments)) { -%>
        // define the path that your publishable resources live
<% } -%>
        $this->sourcePath = "@modules/<%= pluginDirName %>/assetbundles/<%= pluginDirName.toLowerCase() %>/dist";

<% if ((typeof codeComments !== 'undefined') && (codeComments)) { -%>
        // define the dependencies
<% } -%>
        $this->depends = [
            CpAsset::class,
        ];

<% if ((typeof codeComments !== 'undefined') && (codeComments)) { -%>
        // define the relative path to CSS/JS files that should be registered with the page
        // when this asset bundle is registered
<% } -%>
        $this->js = [
            'js/<%= pluginHandle %>.js',
        ];

        $this->css = [
            'css/<%= pluginHandle %>.css',
        ];

        parent::init();
    }
}

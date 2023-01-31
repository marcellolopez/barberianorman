<!DOCTYPE HTML>
<html class="no-js" lang="en">

<head>
    <title>Publish Web</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="stylesheet" href="libs/css/jquery/jquery.ui.css" type="text/css" />
    <link rel="stylesheet" href="libs/css/bizagi-font.css" type="text/css" />
    <link rel="stylesheet" href="libs/css/app.css" type="text/css" />
    <script type="text/javascript" src="libs/js/app/app.bizagi.min.js"></script>
</head>

<body class="off-canvas hide-extras">

    
<!-- *****************************************************************************
 process-viewer
 @author: UX-Team
 @version: 0.1.0
 @url: http://www.bizagi.com
 @date: Feb 20, 2018 10:02 AM 
***************************************************************************** /
 -->

    <div class="biz-ex-wrapper row"></div>

    <div class="alert-box biz-ex-supported">
        <p id="biz-ex-support"></p>
        <a href="http://www.google.com/intl/es-419/chrome/" title="Chrome" target="_blank"><span class="biz-ex-iconbrowser-chrome"></span></a>
        <a href="http://www.mozilla.org/en-US/firefox/new/" title="Firefox" target="_blank"><span class="biz-ex-iconbrowser-firefox"></span></a>
        <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie" title="IE 9+" target="_blank"><span class="biz-ex-iconbrowser-ie"></span></a>
    </div>
    <script type="text/javascript" src="libs/js/app/app.ie8detect.js"></script>

    <script src="key.json.js"></script>
    <script id="json" src="libs/js/json/configuration.json.js"></script>

    <script id="initialization">
        switch (window.location.protocol) {
            case 'http:':
            case 'https:':
                window.isLocal = false;
                break;
            case 'file:':
                window.isLocal = true;
                break;
            default:
                window.isLocal = false;
        }

        if (!PublishWebAttributes) {
            PublishWebAttributes = {
                useTheme: false
            }
        }

        if (PublishWebAttributes.useTheme) {
            var lessScript = document.createElement('script');
            lessScript.id = 'responsive-polyfill';
            lessScript.src = 'libs/js/app/less-1.4.1.min.js';
            document.write(lessScript.outerHTML);
        }


        if (IsIE8Browser()) {
            var polyfillEventListener = document.createElement('script');
            polyfillEventListener.id = 'eventListener-polyfill';
            polyfillEventListener.src = 'libs/js/app/ie8/addEventListener.min.js';
            document.write(polyfillEventListener.outerHTML);

            var modifiedKineticJs = document.createElement('script');
            modifiedKineticJs.id = 'kinetic-ie8';
            modifiedKineticJs.src = 'libs/js/app/ie8/kinetic.min.js';
            document.write(modifiedKineticJs.outerHTML);

            var jQueryScriptForIE8 = document.createElement('script');
            jQueryScriptForIE8.id = 'jquery-ie8';
            jQueryScriptForIE8.src = 'libs/js/app/ie8/jquery.min.js';
            document.write(jQueryScriptForIE8.outerHTML);

        } else {

            var jQueryScriptForModernBrowsers = document.createElement('script');
            jQueryScriptForModernBrowsers.id = 'jquery-modern-browsers';
            jQueryScriptForModernBrowsers.src = 'libs/js/app/jquery.min.js';
            document.write(jQueryScriptForModernBrowsers.outerHTML);

            var kineticJs = document.createElement('script');
            kineticJs.id = 'kinetic';
            kineticJs.src = 'libs/js/app/kinetic.min.js';
            document.write(kineticJs.outerHTML);
        }
    </script>

    <script src="libs/js/app/process-viewer.libraries.min.js"></script>
    <script src="libs/js/app/process-viewer.plugins.min.js"></script>
    <script src="libs/js/app/process-viewer.min.js"></script>
<!-- 
    @name:          Zoomer Template
    @view:          Bizagi.App.Views.DiagramView
    @description:   Diagram Process / Zoom Plugin Markup
-->
<script type="text/x-jquery-tmpl" id="ZoomerViewTmpl">
    <div class="zoom-container" data-zoomcontainer>
        <div data-zoomcontent draggable="true">
        </div>
        <div class="cf zoom-control" data-zoomcontrol>
            <div class="zoom-options">
                <a href="#" class="zoom-icon-zoomexpand btn btn-default zoom-inline" data-zoomexpand><i class=" zoom-inline biz-ex-icon-zoomexpand"></i></a>
            </div>
            <div class="zoom-slider-container">
                <div class="zoom-slider zoom-inline" data-zoomslider></div>
                <div class="zoom-slider-percent zoom-inline" data-zoompercent></div>
            </div>
        </div>
        <div class="zoom-pane-preview" data-zoompanepanel></div>
        <div class="zoom-pane-icon biz-ex-icon-pane-panel" data-zoomiconpanepanel>
            <i class="bz-icon bz-icon-new-close-outline bz-icon-16"></i>
            <i class="bz-icon bz-icon-new-outline bz-icon-16"></i>
        </div>
    </div>
</script>


<!-- 
    @name:      Carousel ( Recursive Function for SubProcess Images )
    @view:      Bizagi.App.Views.NavigationView
    @role:      recursive section
    @function:  Bizagi.Util.renderSubPagesRecursive(idTemplate, data)
-->
<script type="text/x-jquery-tmpl" id="CarouselSubProcessViewTmpl">
        <!-- carousel -->
        {{tmpl(this.data) Bizagi.Util.getTemplate("CarouselSubPagesLI")}}
        {{html Bizagi.Util.renderSubPagesRecursive('CarouselSubProcessTmpl',this.data, true)}}
</script>
<!-- 
    @name:      Navigation View ( Iterate Image Section )
    @view:      Bizagi.App.Views.NavigationView
    @role:      Image Process Iteration
-->
<script type="text/x-jquery-tmpl" id="CarouselSubProcessTmplList">
    
    {{if subPages}}
            {{each subPages}}
                {{tmpl($value) Bizagi.Util.getTemplate("CarouselSubPagesLI")}}
            {{/each}}
    {{/if}}
</script>

<script type="text/x-jquery-tmpl" id="CarouselSubPagesLI">
        <li class="biz-ex-carousel-columns">
            <a href="diagram/${id}" class="biz-ex-navigate biz-ex-navigate-carousel">
                <figure class="biz-ex-diagram">
                    <img src="${Bizagi.Util.serializeResourceURL(image)}" alt="${name}" class="absolute-center"/>
                </figure>
                <div class="biz-figure-data">
                    <h4 class="truncate-text">${name}</h4>
                    {{if isSubprocessPage}}
                        <span>${Bizagi.Util.getResource('subProcess')}</span>
                    {{/if}}
                </div>
            </a>
        </li>
</script>


<!-- 
    @name: Container Template
    @view: General Layout
-->

<script type="text/x-jquery-tmpl" id="ContainerTmpl">
    <section id="sidebar" role="complementary">
        <nav id="sideMenu" role="navigation">
            <ul id="sideMainNav" class="nav-bar">
            </ul>
        </nav>
        <div class="biz-gradien-scroll"></div>
    </section>
    <div class="biz-ex-layout row">
        <div class="large-3 columns biz-ex-navigation-left hide-for-small"></div>
        <div class="large-9 columns biz-ex-diagram-update-panel" id="updatePanelDiagram"></div>
    </div>
</script>
<!-- 
    @name:          Diagram View
    @view:          Bizagi.App.Views.DiagramView
    @description:   Diagram Process / SubProcess visualization 
-->
<script type="text/x-jquery-tmpl" id="DiagramViewTmpl">
    <div class='biz-ex-diagram-view'>
        {{if properties}}
        <div class="biz-ex-diagram-data">
            <dl class="biz-ex-dialog-details">
                {{if author}}
                <dt class="biz-ex-dialog-process-title">${Bizagi.Util.getResource('author')}</dt>
                <dd class="biz-ex-dialog-line">${author}</dd>
                {{/if}}
                <dt class="biz-ex-dialog-process-title"><a href="#dialog/element/${id}" class="biz-ex-more-info biz-ex-navigate" data-css="biz-ex-attributes">${Bizagi.Util.getResource('checkAttributes')}</a></dt>
            </dl>
        </div>
        {{/if}}
        <div id="biz-ex-diagram-view-zoom" class="biz-ex-diagram-view-zoom">
                {{tmpl(this.data) 'ZoomerViewTmpl'}}
        </div>
    </div>
</script>

<!-- 
    @name:          Diagram View
    @view:          Bizagi.App.Views.DiagramView
    @description:   Diagram Process / SubProcess visualization 
-->

<script type="text/x-jquery-tmpl" id="ActionsTmpl">
    {{if presentationAction}}
        <span class="biz-ex-mark-action"></span>
    {{/if}}

    <ul class="biz-ex-element-actions">
        {{if presentationAction}}
                {{if presentationAction.type === 'image'}}
                    <li class="biz-ex-element-action">
                        <a href="${Bizagi.Util.serializeResourceURL(presentationAction.value)}" class="biz-ex-action-file biz-ex-icon-file" data-action="image"></a>
                    </li>
                {{/if}}

                {{if presentationAction.type === 'text'}}
                    <li class="biz-ex-element-action">
                        <a href="#dialog/text/${id}" class="biz-ex-action-text biz-ex-icon-text" data-action="text" data-text="${presentationAction.value}"></a>
                    </li>
                {{/if}}

                {{if presentationAction.type === 'url'}}
                    <li class="biz-ex-element-action">
                        <a href="${Bizagi.Util.serializeResourceURL(presentationAction.value)}" class="biz-ex-action-url biz-ex-icon-url" data-action="url"></a>
                    </li>
                {{/if}}



                {{if presentationAction.type === 'table'}}
                    <li class="biz-ex-element-action">
                        <a href="#dialog/table/${id}" class="biz-ex-action-url biz-ex-icon-url" data-action="table" data-table="${presentationAction.value}"></a>
                    </li>                   
                {{/if}}

                {{if presentationAction.type === 'resource'}}
                    <li class="biz-ex-element-action">
                        <a href="#dialog/resource/${id}" class="biz-ex-action-url biz-ex-icon-url" data-action="resource" data-resource="${Bizagi.Util.serializeResourceURL(presentationAction.value)}"></a>
                    </li>
                {{/if}}
                
                {{if presentationAction.type === 'fileLinked'}}
                    <li class="biz-ex-element-action">
                        <a href="${Bizagi.Util.serializeResourceURL(presentationAction.value)}" class="biz-ex-action-url biz-ex-icon-url" data-action="fileLinked" title="${Bizagi.Util.serializeResourceURL(presentationAction.value)}"></a>
                    </li>
                {{/if}}
            {{/if}}
            {{if isPublished}}
                <li class="biz-ex-element-action">
                    <a href="diagram/${id}" class="biz-ex-action-go-process biz-ex-icon-go-process biz-ex-navigate"></a>
                </li>
            {{/if}}
        
            {{if pageElementRef}}
                {{if elementType === 'LinkIntermediate'}}
                    <li class="biz-ex-element-action">
                        <a href="#element/${idDiagram}/${pageElementRef}" class="biz-ex-action-link-element biz-ex-icon-link-element biz-ex-navigate">${pageElementRef}</a>
                    </li>                   
                {{/if}}
            {{/if}}


            {{if properties}}
                    {{each properties}}
                        {{if processPageRef}}
                            <li class="biz-ex-element-action">
                                <a href="diagram/${pageRef}" class="biz-ex-action-go-process biz-ex-icon-go-process biz-ex-navigate"></a>
                            </li>
                    {{/if}}
                {{/each}}
            {{/if}}
    </ul>
</script>


<!-- 
    @name:          Diagram View
    @view:          Bizagi.App.Views.DiagramView
    @description:   Diagram Process / SubProcess visualization 
-->

<script type="text/x-jquery-tmpl" id="ActionsProcessTmpl">
    {{if presentationAction}}
        <span class="biz-ex-mark-action"></span>
    {{/if}}

    <ul class="biz-ex-element-actions">
        {{if pa}}
            {{if presentationAction}}
                {{if presentationAction.type === 'image'}}
                    <li class="biz-ex-element-action">
                        <a href="${Bizagi.Util.serializeResourceURL(presentationAction.value)}" class="biz-ex-action-file biz-ex-icon-file" data-action="image"></a>
                    </li>
                {{/if}}

                {{if presentationAction.type === 'text'}}
                    <li class="biz-ex-element-action">
                        <a href="#dialog/text/${id}" class="biz-ex-action-text biz-ex-icon-text" data-action="text" data-text="${presentationAction.value}"></a>
                    </li>
                {{/if}}

                {{if presentationAction.type === 'url'}}
                    <li class="biz-ex-element-action">
                        <a href="${Bizagi.Util.serializeResourceURL(presentationAction.value)}" class="biz-ex-action-url biz-ex-icon-url" data-action="url"></a>
                    </li>
                {{/if}}



                {{if presentationAction.type === 'table'}}
                    <li class="biz-ex-element-action">
                        <a href="#dialog/table/${id}" class="biz-ex-action-url biz-ex-icon-url" data-action="table" data-table="${presentationAction.value}"></a>
                    </li>                   
                {{/if}}

                {{if presentationAction.type === 'resource'}}
                    <li class="biz-ex-element-action">
                        <a href="#dialog/resource/${id}" class="biz-ex-action-url biz-ex-icon-url" data-action="resource" data-resource="${Bizagi.Util.serializeResourceURL(presentationAction.value)}"></a>
                    </li>
                {{/if}}
                
                {{if presentationAction.type === 'fileLinked'}}
                    <li class="biz-ex-element-action">
                        <a href="${Bizagi.Util.serializeResourceURL(presentationAction.value)}" class="biz-ex-action-url biz-ex-icon-url" data-action="fileLinked" title="${Bizagi.Util.serializeResourceURL(presentationAction.value)}"></a>
                    </li>
                {{/if}}
            {{/if}}
        {{else}}
            {{if isPublished}}
                <li class="biz-ex-element-action">
                    <a href="diagram/${id}" class="biz-ex-action-go-process biz-ex-icon-go-process biz-ex-navigate"></a>
                </li>
            {{/if}}
        
            {{if pageElementRef}}
                {{if elementType === 'LinkIntermediate'}}
                    <li class="biz-ex-element-action">
                        <a href="#element/${idDiagram}/${pageElementRef}" class="biz-ex-action-link-element biz-ex-icon-link-element biz-ex-navigate">${pageElementRef}</a>
                    </li>                   
                {{/if}}
            {{/if}}


            {{if properties}}
                    {{each properties}}
                        {{if processPageRef}}
                            <li class="biz-ex-element-action">
                                <a href="diagram/${pageRef}" class="biz-ex-action-go-process biz-ex-icon-go-process biz-ex-navigate"></a>
                            </li>
                    {{/if}}
                {{/each}}
            {{/if}}
        {{/if}}
    </ul>
</script>




<!-- 
    @name:          Dialog View
    @view:          Bizagi.App.Views.DialogView
-->
<script type="text/x-jquery-tmpl" id="DialogViewTmpl">
    <div id="myModal" class="reveal-modal biz-ex-height-modal">
        <div id="updateDialogContent">
        </div>
        <div class="biz-ex-action-button">
            <a class="close-reveal-modal"><i class="bz-icon bz-icon-16 bz-icon-close-outline"></i></a>
            <a class="expand-reveal-modal collapsed"><i class="bz-icon bz-icon-16 bz-icon-open-outline biz-ex-icon-expand"></i></a>
            <a class="expand-reveal-modal expanded"><i class="bz-icon bz-icon-16 bz-icon-minimize-close-outline biz-ex-icon-expand"></i></a>
        </div>
    </div>
</script>
<!-- 
    @name:          Dialog View Container
    @view:          Bizagi.App.Views.DialogView
-->
<script type="text/x-jquery-tmpl" id="DialogViewTmplImages">
    <header class="biz-ex-dialog-header">
        <h2 class="biz-ex-dialog-name">&nbsp;</h2>
    </header>
    <div class="biz-ex-dialog-content ">
        <div class="biz-ex-show-resource align-center">
            <img src="${Bizagi.Util.serializeResourceURL(image)}" class="biz-ex-image-resource"/>
        </div>
        <a href="${Bizagi.Util.serializeResourceURL(image)}" target="_blank" class="biz-ex-image-resource-link">${Bizagi.Util.getResource('linktoimage')}</a>
    </div>
</script>



<!-- 
    @name:          Dialog View Container
    @view:          Bizagi.App.Views.DialogView
-->
<script type="text/x-jquery-tmpl" id="DialogViewTmplText">
    <header class="biz-ex-dialog-header">
        <h2 class="biz-ex-dialog-name">&nbsp;</h2>
    </header>
    <div class="biz-ex-dialog-content ">
        <div class="biz-ex-show-resource-text">
            <p>{{html Bizagi.Util.preserveHTML(text)}}</p>
        </div>
    </div>
</script>


<!-- 
    @name:          Dialog View Container
    @view:          Bizagi.App.Views.DialogView
-->
<script type="text/x-jquery-tmpl" id="DialogViewTmplTextDescription">
    <header class="biz-ex-dialog-header">
        <h2 class="biz-ex-dialog-name">${Bizagi.Util.getResource('details')}</h2>
    </header>
    <div class="biz-ex-dialog-content ">
        <div class="biz-ex-show-resource-text">
            {{if description}}
                <h6 class="biz-ex-resource-section">${Bizagi.Util.getResource('description')}</h6>
                <div class="biz-ex-p">{{html description}}</div>
            {{/if}}
            
            {{if mainProcessDescription}}
                <h6 class="biz-ex-resource-section">${Bizagi.Util.getResource('mainPoolDescription')}</h6>
                <div class="biz-ex-p">{{html mainProcessDescription}}</div>
            {{/if}}
            
            {{if mainProcessProperties}}
                <h6 class="biz-ex-resource-section">${Bizagi.Util.getResource('mainPoolProperties')}</h6>
                <div class="biz-ex-dialog-content biz-ex-dialog-properties">
                    <div class="content biz-ex-content-properties">
                    {{if mainProcessProperties}}
                            {{if mainProcessProperties.length}}
                                {{if PublishWebAttributes.subNavigation}}
                                    <div data-magellan-expedition="fixed">
                                        <dl class="sub-nav">
                                            {{each mainProcessProperties}}
                                              <dd data-magellan-arrival="${Bizagi.Util.serializeNames(name)}">
                                                    <a href="#${Bizagi.Util.serializeNames(name)}">
                                                        ${name}
                                                    </a>
                                                </dd>
                                            {{/each}}
                                        </dl>
                                    </div>
                                {{/if}}

                                {{tmpl(mainProcessProperties) Bizagi.Util.getTemplate("PropertiesViewTmpl")}}
                            {{else}}
                                {{tmpl(this.data) Bizagi.Util.getTemplate("empty")}}
                            {{/if}}
                    {{else}}
                        {{tmpl(this.data) Bizagi.Util.getTemplate("empty")}}
                    {{/if}}
                    </div>
                </div>
            {{/if}}
        </div>
    </div>
</script>


<!-- 
    @name:          Dialog View Container
    @view:          Bizagi.App.Views.DialogView
-->
<script type="text/x-jquery-tmpl" id="DialogViewTmplHTML">
    <header class="biz-ex-dialog-header">
        <h2 class="biz-ex-dialog-name">${name}</h2>
    </header>
    <div class="biz-ex-dialog-content ">
        <div class="biz-ex-show-resource-text">
            <p>{{html Bizagi.Util.preserveHTML(text)}}</p>
        </div>
    </div>
</script>
<script type="text/x-jquery-tmpl" id="DialogViewTmplPerformers">
    
    <h2 class="biz-ex-performer-header biz-ex-dialog-name">${name}</h2>
    <ul class="biz-ex-performers">
        {{each elements}} 
            <li class="biz-ex-performer">
                <h3 class="biz-ex-performer-title"><span class="biz-ex-performer-tag">${name}</span> ${rol}</h3>
                {{if description}}
                    <p class="biz-ex-performer-description">${description}</p>
                {{/if}}        
            </li>
        {{/each}}
    </ul>
</script>
<!--
    @name:          Dialog View Container
    @view:          Bizagi.App.Views.DialogView
-->
<script type="text/x-jquery-tmpl" id="DialogViewTmplProperties">

    <header class="biz-ex-dialog-header">
        <h1 class="biz-ex-title-process">${nameDiagram}</h1>
        <h2 class="biz-ex-dialog-name">${name}</h2>
        <dl class="biz-ex-dialog-properties">
            {{if performers}}
            <dt class="biz-ex-dialog-process-title">
                ${Bizagi.Util.getResource('performer')}
            </dt>
            <dd>
                <div class="biz-ex-performers-list-as-contact">
                    {{tmpl(Bizagi.Util.renderPerformers(performers, 10)) "DialogViewTmplPropertiesPerformers"}}
                </div>
            </dd>
            {{/if}}
            {{if accountable}}
            <dt class="biz-ex-dialog-process-title">
                ${Bizagi.Util.getResource('accountable')}
            </dt>
            <dd>
                <div class="biz-ex-performers-list-as-contact">
                    {{tmpl(Bizagi.Util.renderPerformers(accountable, 10)) "DialogViewTmplPropertiesPerformers"}}
                </div>
            </dd>
            {{/if}}
            {{if consulted}}
            <dt class="biz-ex-dialog-process-title">
                ${Bizagi.Util.getResource('consulted')}
            </dt>
            <dd>
                <div class="biz-ex-performers-list-as-contact">
                    {{tmpl(Bizagi.Util.renderPerformers(consulted, 10)) "DialogViewTmplPropertiesPerformers"}}
                </div>
            </dd>
            {{/if}}
            {{if informed}}
            <dt class="biz-ex-dialog-process-title">
                ${Bizagi.Util.getResource('informed')}
            </dt>
            <dd>
                <div class="biz-ex-performers-list-as-contact">
                    {{tmpl(Bizagi.Util.renderPerformers(informed, 10)) "DialogViewTmplPropertiesPerformers"}}
                </div>
            </dd>
            {{/if}}
            {{if description}}
            {{if !Bizagi.Util.validateLength(description)}}
            <dt class="biz-ex-dialog-process-title">
                ${Bizagi.Util.getResource('description')}
            </dt>
            <dd class="biz-ex-dialog-description">
                {{tmpl(Bizagi.Util.renderDescriptionPreview(description, PublishWebAttributes.maxLenghtDescription)) "DialogViewTmplPropertiesDescription"}}
            </dd>
            {{/if}}
            {{/if}}

            {{if presentationAction }}

            <dt class="biz-ex-dialog-process-title" data-pa="${this.data.pa = true}">
                ${Bizagi.Util.getResource('presentationAction')}
            </dt>
            <dd class="biz-ex-dialog-presentation">
                {{tmpl(this.data) Bizagi.Util.getTemplate("ActionsProcessTmpl")}}
            </dd>
            {{/if}}

            {{if this.data.elementType}}

            <dt class="biz-ex-dialog-process-title" data-pa="${this.data.pa = false}">
                {{if this.data.elementType === "CallActivity"}}
                ${Bizagi.Util.getResource('process')}
                {{/if}}
                {{if this.data.elementType === 'SubProcess' && this.data.isPublished}}
                ${Bizagi.Util.getResource('subProcess')}
                {{/if}}
            </dt>
            <dd class="biz-ex-dialog-presentation">
                {{tmpl(this.data) Bizagi.Util.getTemplate("ActionsProcessTmpl")}}
            </dd>
            {{/if}}

        </dl>
    </header>
    <div class="biz-ex-dialog-content biz-ex-dialog-properties">
        <div class="content biz-ex-content-properties">
            {{if properties}}
            {{if properties.length}}
            {{if PublishWebAttributes.subNavigation}}
            <div data-magellan-expedition="fixed">
                <dl class="sub-nav">
                    {{each properties}}
                    <dd data-magellan-arrival="${Bizagi.Util.serializeNames(name)}">
                        <a href="#${Bizagi.Util.serializeNames(name)}">
                            ${name}
                        </a>
                    </dd>
                    {{/each}}
                </dl>
            </div>
            {{/if}}
            {{tmpl(properties) Bizagi.Util.getTemplate("PropertiesViewTmpl")}}
            {{/if}}
            {{/if}}

            {{if elementType}}
            {{if Bizagi.Util.validateForValidTasks(elementType)}}
            {{if pageElements}}
            <div class="biz-ex-pageElements">
                {{each pageElements}}
                <div class="biz-ex-pageElement">
                    <a name="${Bizagi.Util.serializeNames(name)}"></a>
                    <h5 class="biz-ex-property-title" data-magellan-destination="${Bizagi.Util.serializeNames(name)}">
                        {{if elementType}}<i class="biz-ex-result-icon biz-ex-icon-${elementType}"></i>{{/if}}${name}
                    </h5>
                    {{if properties}}
                    {{tmpl(properties) Bizagi.Util.getTemplate("PropertiesViewTmpl")}}
                    {{/if}}
                </div>
                {{/each}}
            </div>
            {{/if}}
            {{/if}}
            {{else}}
            <!-- DRAGON-12111 : Participant properties are not exported to Web -->
            {{if elements}}
            {{if elements.length}}
            {{each elements}}
            {{tmpl(properties) Bizagi.Util.getTemplate("PropertiesViewTmpl")}}
            {{/each}}
            {{/if}}
            {{/if}}
            <!-- / -->
            {{/if}}

            {{if Bizagi.Util.validateForEmpty(this.data)}}
            {{tmpl(this.data) Bizagi.Util.getTemplate("empty")}}
            {{/if}}
        </div>
    </div>
</script>


<!--
    @name:          Dialog View Container
    @view:          Bizagi.App.Views.DialogView
-->
<script type="text/x-jquery-tmpl" id="empty">
    <div class="alert-box biz-ex-alert-message">
        ${Bizagi.Util.getResource('emptyElement')}
    </div>
</script>



<!--
    @name:          Dialog View Container
    @view:          Bizagi.App.Views.DialogView
-->
<script type="text/x-jquery-tmpl" id="DialogViewTmplPropertiesPerformers">

    <div class="biz-ex-collapsible">

        {{if isLarge}}
        {{if hidden}}
        <a href="#more" class="biz-ex-badge biz-ex-more">${Bizagi.Util.getResource('more')}</a>
        {{/if}}
        <div class="biz-ex-is-collapsible">
            {{each showed}}
            <span class="biz-ex-performer-tag">${$value.name}</span>
            {{/each}}
        </div>
        {{if hidden}}
        <div class="biz-ex-is-extended biz-ex-is-hidden">
            <a href="#less" class="biz-ex-badge biz-ex-less">${Bizagi.Util.getResource('less')}</a>
            <div>
                {{each showed}}
                <span class="biz-ex-performer-tag">${$value.name}</span>
                {{/each}}
                {{each hidden}}
                <span class="biz-ex-performer-tag">${$value.name}</span>
                {{/each}}
            </div>
        </div>
        {{/if}}
        {{else}}
        <div>
            {{each showed}}
            <span class="biz-ex-performer-tag">${$value.name}</span>
            {{/each}}
        </div>
        {{/if}}

    </div>

</script>

<!--
    @name:          Dialog View Container
    @view:          Bizagi.App.Views.DialogView
-->
<script type="text/x-jquery-tmpl" id="DialogViewTmplPropertiesDescription">

    {{if isLarge}}
    <div class="biz-ex-collapsible">
        {{else}}
        <div class="biz-ex-collapsible biz-max-wrapper">
            {{/if}}

            {{if isLarge}}
            <div class="biz-ex-is-collapsible">
                ${descriptionSummary}
                <div class="biz-ex-badge biz-ex-expand-description biz-ex-expand-button">
                    <a href="dialog/expand/description" class="biz-ex-navigate"> ${Bizagi.Util.getResource('expand')} </a>
                </div>
            </div>
            {{if descriptionComplete}}
            <div class="biz-ex-is-extended biz-ex-is-hidden">
                <a href="" class="biz-ex-badge biz-ex-less">${Bizagi.Util.getResource('less')}</a>
                <div>
                    {{html descriptionComplete}}
                </div>
            </div>

            {{/if}}
            {{else}}
            <div class="biz-ex-is-collapsible biz-max-height">
                {{html descriptionComplete}}
            </div>
            {{/if}}

        </div>
</script>
<!-- 
    @name:          Dialog View Container
    @view:          Bizagi.App.Views.DialogView
-->
<script type="text/x-jquery-tmpl" id="DialogViewTmplSubProcess">

    <header class="biz-ex-dialog-header">
        <h2 class="biz-ex-dialog-name">${name}</h2>
        <dl class="biz-ex-dialog-details">
            <dt class="biz-ex-dialog-line">${Bizagi.Util.getResource('process')}</dt>
            <dt class="biz-ex-dialog-process-title">${Bizagi.Util.getResource('contain')}</dt>
            <dd class="biz-ex-dialog-line">${Bizagi.Util.getSubProcesses(this.data)} ${Bizagi.Util.getResource('subProcess')}</dd>
            <dt class="biz-ex-dialog-process-title">${Bizagi.Util.getResource('author')}</dt>
            <dd>${author}</dd>
        </dl>
        {{if properties}}
            <div class="biz-ex-tabs-overview">
                <a href="#panel1" class="biz-ex-more-info" data-css="biz-ex-overview">${Bizagi.Util.getResource('checkOverview')}</a>
                <a href="#panel2" class="biz-ex-more-info" data-css="biz-ex-attributes">${Bizagi.Util.getResource('checkAttributes')}</a>
            </div>
        {{/if}}
    </header>
    <div class="biz-ex-dialog-content">
        <div class="section-container auto" data-section>
            <section class="active bix-ex-section-overview-n-carousel">
                <p class="title biz-ex-more-info-diagram biz-ex-is-hidden" data-section-title><a href="#panel1">Section 1</a></p>
                <div class="content">
                    <div class="row">
                        <figure class="biz-ex-diagram biz-ex-diagram-process large-6 columns">
                            <div class="biz-ex-image-wrapper">
                                <a href="diagram/${id}" class="biz-ex-image-border biz-ex-navigate">
                                    <img src="${Bizagi.Util.serializeResourceURL(image)}" alt="${name}" class="biz-ex-diagram-image absolute-center"/>
                                </a>
                            </div>
                        </figure>
                        <div class="biz-ex-figure-collection large-6 columns">
                            <div class="biz-ex-carousel">
                                
                                <div class="biz-ex-carousel-back">
                                    {{if Bizagi.Util.getSubProcesses(this.data) > 4 }}
                                        <span class="biz-ex-icon-back biz-ex-icon-carousel"></span>
                                    {{/if}}
                                </div>
                                
                                <div class="row biz-ex-row">
                                    <div class="biz-ex-carousel-container large-12 columns">
                                        <ul>
                                        {{if subPages }}
                                            {{each subPages}}
                                                {{tmpl($value) Bizagi.Util.getTemplate("CarouselSubProcessViewTmpl")}}
                                            {{/each}}
                                        {{/if}}
                                        </ul>
                                    </div>
                                </div>
                                
                                <div class="biz-ex-carousel-next">
                                    {{if Bizagi.Util.getSubProcesses(this.data) > 4 }}
                                        <span class="biz-ex-icon-next biz-ex-icon-carousel"></span>
                                    {{/if}}
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section calss="bix-ex-section-attributes ">
                <p class="title biz-ex-more-info-properties biz-ex-is-hidden" data-section-title><a href="#panel2">Section 2</a></p>
                <div class="content row">
                    {{if PublishWebAttributes.subNavigation}}
                    <div data-magellan-expedition="fixed">
                        <dl class="sub-nav">
                            {{each properties}}
                              <dd data-magellan-arrival="${Bizagi.Util.serializeNames(name)}">
                                    <a href="#${Bizagi.Util.serializeNames(name)}">
                                        ${name}
                                    </a>
                                </dd>
                            {{/each}}
                        </dl>
                    </div>
                    {{/if}}
                    {{if properties}}
                            {{tmpl(properties) Bizagi.Util.getTemplate("PropertiesViewTmpl")}}
                    {{/if}}
                </div>
            </section>
        </div>
    </div>
    
</script>
<!-- 
    @name:          Diagram View
    @view:          Bizagi.App.Views.ErrorView 
    @description:   Fires when ID diagram not exist 
-->
<script type="text/x-jquery-tmpl" id="ErrorViewTmpl">
    <div class='biz-ex-error-view'>
        <h3>${Bizagi.Util.getResource('errorPage')}  </h3>
        <div class='biz-ex-box-process'>${message}  ${id}</div>
    </div>
</script>
<!-- 
    @name:      GUID View
    @view:      Bizagi.App.Views.TableView
-->
<script type="text/x-jquery-tmpl" id="GuidViewTmpl">
    <div class='row biz-ex-guid-view'>
        {{each pages}}
            {{tmpl($value) "GuidViewRecursiveTmpl"}} 


            {{if subPages}}
                {{tmpl(Bizagi.Util.getSubProcessesObject($value)) "GuidViewRecursiveTmpl"}}                   
            {{/if}}

            
        {{/each}}
    </div>
</script>


<script type="text/x-jquery-tmpl" id="GuidViewRecursiveTmpl">
    <div class="large-6 columns biz-ex-guid-element">
        <div class="biz-ex-guid-wrapper">
            <div class="biz-ex-guid-img">
                <img src="${Bizagi.Util.serializeResourceURL(image)}" alt="${name}" />
            </div>
            <div class="biz-ex-guid-body">
                <p class="biz-ex-guid"><strong>#diagram/${id}</strong></p>
                <p class="biz-ex-guid-name">${name}</p>
            </div>
        </div>
    </div>
</script>




<!-- 
    @name: Header View Template
    @view: Bizagi.App.Views.HeaderView
-->
<script type="text/x-jquery-tmpl" id="HeaderViewTmpl">
    <div class="large-3 columns biz-ex-logo">
        <a class="show-for-small button sidebar-button" id="sidebarButton" href="#sidebar">
            <img src="libs/img/biz-ex-icon-menu.png" />
        </a>
        <a href="list/" class="biz-ex-navigate biz-ex-logo-navigate">
            <i class="biz-ex-logo-img"></i>
        </a>
    </div>
    <div class="large-9 columns biz-ex-top-nav">
        <a class="biz-ex-back-process"></a>
        <div class="large-7 columns biz-ex-navigation-data">
            <h1 class="biz-ex-title-process">
                <a href="list/" class="biz-ex-navigate" title="${Bizagi.Util.getResource('home')}">${process}</a>
            </h1>
            <h2 class="biz-ex-title-diagram" title="${name}">${name}</h2>
            {{if PublishWebAttributes.showPublishDate}}
            <p class="biz-ex-time"><time datetime="${publishDate}">${publishDate}</time></p>
            {{/if}}
        </div>
        <nav class="hide-for-small large-5 columns">
            <ul class="cf biz-ex-user-options">
                {{if PublishWebAttributes.showPerformersList}}
                <li>
                    <a href="dialog/performers" class="biz-ex-icon-performers biz-ex-navigate" title="${Bizagi.Util.getResource('performers')}"></a>
                </li>
                {{/if}}
                <li>
                    <a href="fullscreen" class="biz-ex-full-screen-modifier biz-ex-navigate" title="${Bizagi.Util.getResource('fullscreen')}">
                        <i class="bz-icon bz-icon-16 bz-icon-maximize-outline"></i>
                    </a>
                </li>
                {{if !Bizagi.AppModel.personalized}}
                <li>
                    <a href="http://www.bizagi.com/" target="_blank" class="biz-ex-bizagi">${Bizagi.Util.getResource('visitBizagi')}</a>
                </li>
                {{/if}}
            </ul>
        </nav>
    </div>
</script>

<script type="text/x-jquery-tmpl" id="AlertViewTmpl">
    <div data-alert class="alert-box biz-ex-alert">
        <p class="biz-ex-alert-content">{{html message}}</p>
    </div>
</script>
<!-- 
    @name: Navigation View Template
    @view: Bizagi.App.Views.NavigationView
    @role: Principal
-->
<script type="text/x-jquery-tmpl" id="NavigationViewTmpl">
    <nav id="menu" role="navigation">
        <ul id="mainNav" class="nav-bar">
            {{each pages}}
            <li class="biz-ex-sub-page">
                <a href="diagram/${id}" class="biz-ex-navigate" title="${name}">
                    <div class="truncate-text biz-ex-name biz-ex-menu">${name}</div>
                    {{if Bizagi.Util.getSubProcesses($value) >= 1}}
                    <div class="biz-ex-ind-container">
                        <i class="biz-ex-icon-plus bz-icon bz-icon-plus"></i>
                    </div>
                    {{/if}}
                </a>
                {{if subPages}}
                <div class="biz-ex-subPages">
                    {{html Bizagi.Util.renderSubPagesRecursive('NavigationSubViewTmpl',{subPages:subPages})}}
                </div>
                {{/if}}
            </li>
            {{/each}}
        </ul>
    </nav>
    <div class="biz-gradien-scroll"></div>
</script>

<!-- 
    @name: Navigation View Template
    @view: Bizagi.App.Views.NavigationView
    @role: Clone from Proncipal Menu (for Devices)
-->
<script type="text/x-jquery-tmpl" id="CloneNavigationViewTmpl">
    {{each pages}}
    <li class="biz-ex-sub-page">
        <a href="diagram/${id}" class="biz-ex-navigate" title="${name}">
            <div class="truncate-text biz-ex-name biz-ex-menu">${name}</div>
            {{if Bizagi.Util.getSubProcesses($value) > 1}}
            <div class="biz-ex-icon-plus bz-icon bz-icon-plus"></div>
            {{/if}}
        </a>
        {{if subPages}}
        <div class="biz-ex-subPages">
            {{html Bizagi.Util.renderSubPagesRecursive('NavigationSubViewTmpl',{subPages:subPages})}}
        </div>
        {{/if}}
    </li>
    {{/each}}
</script>
<!-- 
    @name:      Navigation View ( Iterate section )
    @view:      Bizagi.App.Views.NavigationView
    @role:      Diagram Link Iteration
-->
<script type="text/x-jquery-tmpl" id="NavigationSubViewTmpl">
    {{if subPages}}
    <ul>
        {{each subPages}}
        <li class="biz-ex-sub-page">
            <a href="diagram/${id}" class="biz-ex-navigate" title="${$value.name}">
                <div class="truncate-text biz-ex-name biz-ex-menu">${$value.name}</div>
            </a>
            <div class="biz-ex-subPages"></div>
        </li>
        {{/each}}
    </ul>
    {{/if}}
</script>
<!-- 
    @name:      Navigation View ( Iterate Image Section )
    @view:      Bizagi.App.Views.NavigationView
    @role:      Image Process Iteration
-->
<script type="text/x-jquery-tmpl" id="NavigationSubProcessTmpl">
    {{if subPages}}
    <ul>
        {{each subPages}}
        <li>
            <a href="diagram/${id}" class="biz-ex-navigate" title="${name}">
                <figure class="biz-ex-diagram large-4 columns">
                    <img src="${Bizagi.Util.serializeResourceURL(image)}" alt="${name}" />
                </figure>
            </a>
            <div class="biz-ex-subPages"></div>
        </li>
        {{/each}}
    </ul>
    {{/if}}
</script>
<!-- 
    @name:          Properties View
-->
<script type="text/x-jquery-tmpl" id="PropertiesViewTmpl">
            <div>
                {{if type === 'text'}}
                    {{if value}}
                        <div class="biz-ex-property">
                            <a name="${Bizagi.Util.serializeNames(name)}"></a>
                                <h5 class="biz-ex-property-title" data-magellan-destination="${Bizagi.Util.serializeNames(name)}">${name}</h5>
                                {{tmpl(this.data) 'PropertiesValueViewTmpl'}}
                        </div>
                    {{/if}}
                {{else}}
                    <div class="biz-ex-property">
                        <a name="${Bizagi.Util.serializeNames(name)}"></a>
                        <h5 class="biz-ex-property-title" data-magellan-destination="${Bizagi.Util.serializeNames(name)}">${name}</h5>
                        {{tmpl(this.data) 'PropertiesValueViewTmpl'}}
                    </div>
                {{/if}}
            </div>
</script>


<script type="text/x-jquery-tmpl" id="PropertiesTableViewTmpl">
    <div class="biz-ex-x-scroll">
        <table class="biz-ex-table">
            <thead>
                {{each headers}}
                    <th>${$value.value}</th>
                {{/each}}
            </thead>
            <tbody>
                {{each table}}
                    <tr>
                        {{each $value}}
                            <td>
                            {{tmpl($value) 'PropertiesValueViewTmpl'}}
                            </td>
                        {{/each}}
                    </tr>
                {{/each}}
            </tbody>
        </table>
    </div>
</script>

<script type="text/x-jquery-tmpl" id="PropertiesDLViewTmpl">
    <ul class="biz-ex-list">
    {{each list}}
        <li class="biz-ex-title">${$value.header}</li>
        {{if $value.list}}
            <ul>
            {{each $value.list}}
                <li>
                    {{tmpl($value) 'PropertiesValueViewTmpl'}}
                </li>
            {{/each}}
            </ul>
        {{/if}}
    {{/each}}
    </ul>
</script>


<script type="text/x-jquery-tmpl" id="PropertiesDLRowViewTmpl">
    <ul class="biz-ex-list">
        {{each table}}
            <li class="biz-ex-row">
                {{each $value}}
                    <div class="biz-ex-element">
                        <span class="biz-ex-name">${name}</span>
                        {{tmpl($value) 'PropertiesValueViewTmpl'}}
                    </div>
                {{/each}}
            </li>
        {{/each}}
    </ul>
</script>

<script type="text/x-jquery-tmpl" id="PropertiesValueViewTmpl">

        {{if description}}
            <h6>${Bizagi.Util.getResource('description')}</h6>
            <div class="biz-ex-property-description">
                {{html Bizagi.Util.preserveHTML(description)}}
            </div>
        {{/if}}

        {{if type === 'text'}}
            {{if value}}
                {{html value}}
            {{/if}}
        {{/if}}

        {{if type === 'image'}}
            {{if value}}
            <div class="biz-ex-property-image">
                <img src="${Bizagi.Util.serializeResourceURL(value)}" class="biz-ex-property-img" />
            </div>
            {{/if}}
        {{/if}}
    
        {{if type === 'url' || type === 'fileLinked'}}
            {{if this.data.pageRef}}
                <div class="biz-ex-property-url biz-ex-process-link">
                    <div class="biz-ex-validate-resource" data-url="${Bizagi.Util.serializeResourceURL(value)}" data-execute="validatePropertyResource">
                        <div class="biz-ex-validation">
                            <a href="diagram/${this.data.pageRef}" class="biz-ex-action-go-process biz-ex-navigate">{{if urlText}} ${urlText} {{else}} ${value} {{/if}}</a>
                        </div>
                    </div>
                </div>
            {{else}}
                {{if value}}
                <div class="biz-ex-property-url">
                        <div class="biz-ex-validate-resource" data-url="${Bizagi.Util.serializeResourceURL(value)}" data-execute="validatePropertyResource">
                            <div class="biz-ex-validation">
                                <a href="${Bizagi.Util.serializeResourceURL(value)}" target="_blank" class="biz-ex-url" title="${Bizagi.Util.serializeResourceURL(value)}">{{if urlText}} ${urlText} {{else}} ${value} {{/if}}</a>
                            </div>
                        </div>
                </div>
                {{/if}}
            {{/if}}
        {{/if}}

        {{if type === 'table'}}
            {{if table.exportAsTable}}
                {{tmpl(table) Bizagi.Util.getTemplate("PropertiesTableViewTmpl")}}
            {{else}}
                {{html Bizagi.Util.getTableAsListByRow(table)}}
            {{/if}}
        {{/if}}
</script>

<!-- 
    @name: Search View Template
    @view: Bizagi.App.Views.SearchView
-->
<script type="text/x-jquery-tmpl" id="SearchTmpl">
    <form class="biz-ex-search {{if PublishWebAttributes.showPerformersList}}biz-ex-is-performers{{/if}}">
        <div class="biz-ex-search-wrapper">
            <!-- span name="search-options" class="biz-ex-icon-search biz-ex-btn-search"></span -->
            <span name="search-options" class="biz-ex-btn-search">
                <i class="bz-icon bz-icon-16 bz-icon-search-down-arrow"></i>
            </span>
            <input type="input" class="biz-ex-search-input" placeholder="${Bizagi.Util.getResource('search')}" autocomplete="on">
            <ul class="biz-ex-search-options biz-ex-is-hidden">
                <li class="biz-ex-search-item">
                    <a href="#" class="biz-ex-search-option biz-ex-active active" data-type="global">${Bizagi.Util.getResource('searchGlobal')}</a>
                </li>
                <li class="biz-ex-search-item">
                    <a href="#" class="biz-ex-search-option" data-type="local">${Bizagi.Util.getResource('searchLocal')}</a>
                </li>
            </ul>
        </div>
    </form>
</script>
<!-- 
    @name: Search Results View Template
    @view: Bizagi.App.Views.SearchView
-->
<script type="text/x-jquery-tmpl" id="SearchTmplResults">
    
    <li>
        <a href="#" class="biz-ex-result">
            <i class="biz-ex-result-icon biz-ex-icon-${elementType}"></i>
            <p class="biz-ex-result-name">${label}</p>
            <p class="biz-ex-result-container">${container}</p>
        </a>
    </li>

</script>


<script type="text/x-jquery-tmpl" id="SearchTmplResultsAlert">
    <div data-alert class="alert-box biz-ex-result-alert">
        <p class="biz-ex-result-alert-content">${Bizagi.Util.getResource('searchResults')}</p>
    </div>
</script>
<!-- 
    @name:      List/Table View
    @view:      Bizagi.App.Views.TableView
-->
<script type="text/x-jquery-tmpl" id="TableViewTmpl">
    <div class='row biz-ex-table-view'></div>
</script>
<script type="text/x-jquery-tmpl" id="TableViewTmplItem">
    <div>
        {{if hasPublishedSubPages}}
        <a href="dialog/diagram/${id}" class='columns large-4 biz-ex-box-process biz-ex-dialog biz-ex-navigate' data-id="${id}">
        {{else}}
            <a href="diagram/${id}" class='columns large-4 biz-ex-box-process biz-ex-navigate'>
        {{/if}}
            <span class="biz-ex-is-hidden">dialog/diagram/${id}</span>
            <div class="bix-ex-figure-panel">
                <figure class="biz-ex-overview-process" data-figureID="${id}"></figure>   
            </div>
        </a>
    </div>
</script>
<script type="text/x-jquery-tmpl" id="TableViewTmplExPanel">
        <div>    
            <div class="biz-ex-panel">
                <div class="biz-ex-img">
                    <img src="${Bizagi.Util.serializeResourceURL(page.image)}" alt="${page.name}" class="absolute-center biz-ex-diagram-img-fit">
                </div>
                <h2 class="truncate-text biz-ex-diagram-name">${page.name}</h2>
                {{if page.hasSubPages}}
                    <p class="biz-ex-diagram-sub">${Bizagi.Util.getSubProcesses(page)} ${Bizagi.Util.getResource('subProcess')}</p>
                {{/if}}
            </div>
            <div class="biz-ex-over-panel">
                <h2 class="truncate-text biz-ex-diagram-name">${page.name}</h2>
                <div class="biz-ex-diagram-desc-wrapper">
                    <div class="biz-ex-diagram-desc-container">
                        {{if mainProcessDescription.summary}}
                            <p class="biz-ex-diagram-desc">${mainProcessDescription.summary}</p>
                        {{else}}
                            {{if page.description}}
                                <p class="biz-ex-diagram-desc">${description.summary}</p>
                            {{/if}}
                        {{/if}}
                    </div>
                    {{if mainProcessDescription.summary}}
                        {{if mainProcessDescription.expand}}
                                <span data-link="dialog/description" class="biz-ex-navigate biz-ex-expand-button-span">${Bizagi.Util.getResource('expand')}</span>
                        {{/if}}
                     {{else}}
                        {{if description.expand}}
                                <span data-link="dialog/description" class="biz-ex-navigate biz-ex-expand-button-span">${Bizagi.Util.getResource('expand')}</span>
                        {{/if}}
                    {{/if}}
                </div>                        
                {{if page.hasSubPages}}
                    <p class="biz-ex-diagram-sub">${Bizagi.Util.getResource('contain')} ${Bizagi.Util.getSubProcesses(page)} ${Bizagi.Util.getResource('subProcess')}</p>                   
                {{/if}}
            </div>
        </div>
</script>
<div id="lessParser" class="biz-ex-hide"> 

/*******************************************************************************
    @theme: Export Process Viewer
    @version: 2.0.0
    @author: UX TEAM at Bizagi
    @description: Custom theme CSS rules for Process Viewer
********************************************************************************/

/* ==========================================================================
   Export process viewer components
   ========================================================================== */

/* General
   ========================================================================== */

::-webkit-input-placeholder { color: @navigation-link; }

::-moz-placeholder { color: @navigation-link; }

:-ms-input-placeholder { color: @navigation-link; }

a{
    color:@navigation-link;
}

a:hover{
    color:darken(@navigation-link, 30%) !important;
}

h1, h2, h3, h4, h5, h6,
p, span, div,
body, html{
    font-family: @font-family, Helvetica, Arial, sans-serif;
}


.biz-ex-dialog-content {
    font-family: @font-family, Helvetica, Arial, sans-serif !important;

    ul,
    li,
    span,
    table,
    td,
    p,
    h2,
    h1,
    div {
        font-family: @font-family, Helvetica, Arial, sans-serif !important;
    }
}

#app-container-view { background: lighten(@navigation, 5%); }

.ui-tooltip.biz-ex-tooltip,
.ui-tooltip.biz-ex-tooltip-nav {
    background: @content;
    color: @content-text;
}

.ui-tooltip.biz-ex-tooltip:after { border-left-color: @content; }

.ui-tooltip.biz-ex-tooltip-nav:after { border-right-color: @content; }

.biz-gradien-scroll {
    background: -webkit-linear-gradient(top, transparent 0%, darken(@navigation, 10%) 100%);
    background:    -moz-linear-gradient(top, transparent 0%, darken(@navigation, 10%) 100%);
    background: linear-gradient(to bottom, transparent 0%, darken(@navigation, 10%) 100%);
}

/* Header
   ========================================================================== */

   .bz-icon{
       color:@icon-color;
   }



.biz-ex-header-view {
    border-bottom-color: @header-border;
    a {
        color: @header-link;
        &:hover { color: darken(@header-link, 5%); }
    }
}

.lt-ie9 .biz-ex-header-view{
    background:darken(@header, 6%);
}

.biz-ex-logo {
    background:darken(@header, 6%);
    border-right-color: @header-border;
    border-bottom-color: @header-border;
}

.biz-ex-top-nav {
    background: darken(@header, 6%);
}

.biz-ex-back-process.biz-ex-navigate {
    border-color: @header-border;
    background: transparent;
}

.biz-ex-title-diagram { color: @header-link; }

/* Navigation sidebar
   ========================================================================== */

#sidebar,
.biz-ex-navigation-left { background: darken(@navigation, 5%); }

.biz-ex-navigation-left { border-right-color: @navigation-border; }

.biz-ex-search-input,
.biz-ex-icon-search { background-color: darken(@navigation, 10%); }

.biz-ex-search-input { color: @navigation-link; }

.nav-bar {
    border-top-color: @navigation-border;
    .biz-ex-sub-page a { border-bottom-color: @navigation-border; }
    .biz-ex-sub-page.active { background: fade(@navigation-link, 25%); }
    a {
        color: @navigation-link;
        &:hover {
            background: darken(@navigation, 10%);
            color: darken(@navigation-link, 5%);
        }
    }
}

.biz-ex-active.active > a {
    border-top-color: @navigation-border !important;
    color: darken(@navigation-link, 40%);
}

.biz-ex-active.active .biz-ex-ind-container,
.biz-ex-ind-container { border-right-color: transparent; }

/* Search
   ========================================================================== */

.biz-ex-search-options {
    box-shadow: 0 1px 1px darken(@content, 25%);
    background: fade(@content, 90%);
}

.biz-ex-search-options:after {
    border-bottom-color: fade(@content, 90%);
}

.ui-autocomplete {
    box-shadow: 0 1px 1px darken(@content, 25%);
    background: fade(@content, 90%);
}

.biz-ex-result-name,
.biz-ex-result-container {
    color: @content-text !important;
}

.biz-ex-search-option { color: @navigation-link; }

.biz-ex-search-option.biz-ex-active { color: @content-text; }

/* Content
   ========================================================================== */

.biz-ex-diagram-data { background: @content; }

.no-touch .bix-ex-figure-panel {
    border-color: @content-border;
    background: @content;
}

h1, h2, h3, h4, h5, h6,
.biz-ex-diagram-desc-container { color: @content-text; }

.biz-ex-img,
.biz-ex-diagram-desc:last-child { border-color: lighten(@content-border, 25%); }


.biz-ex-expand-button-span {
    border-color: @navigation-border !important;
    background: @content;
    color:@navigation-link;
}

.biz-ex-badge{
    border-color: @navigation-border !important;
}

.biz-ex-navigate:hover .biz-ex-expand-button-span{
    color:lighten(@navigation-link, 30%) !important;
}

.biz-ex-expand-button-span::after{
    border-top-color: lighten(@navigation-link, 30%) !important;
}

.no-touch .bix-ex-figure-panel:hover{
    border-color: @hover-dashboard-panel;
}

/* Modal window
   ========================================================================== */

.reveal-modal { border-color: @content-border }

.biz-ex-dialog-header { background: lighten(@header, 25%); }

.biz-ex-dialog-details > dt, 
.biz-ex-dialog-details > dd,
.biz-ex-dialog-properties .biz-ex-dialog-process-title,
.biz-ex-performers-list-as-contact span,
.biz-ex-performers-list-as-contact span:nth-child(even) { color: @content-text; }

.biz-ex-dialog-line { border-color: @content-border; }

.biz-ex-performer-tag { background: darken(@content, 10%); }

.biz-ex-dialog-content.biz-ex-dialog-properties {
    bottom: 4px;
    border-top-color: @content-border;
}

.alert-box {
    background: darken(@content, 10%) !important;
    color: @content-text;
}

.alert-box.biz-ex-alert-message{
    background: lighten(@alert-box-message, 40%) !important;
    color: darken(@alert-box-message, 20%);
}

/* GUID list
   ========================================================================== */

.biz-ex-guid-wrapper { 
    border-color: @content-border;
    background: @content;
    color: @content-text;
}

.biz-ex-guid-img { border-color: lighten(@content-border, 25%); }

/* Zoom
   ========================================================================== */

.zoom-hotspot:hover {
    border-color: transparent;
    background-color: fade(@navigation, 50%);
}

.zoom-pane-preview {
    border-color: @header-border; 
}

.zoom-pane-preview .zoom-pane-square {
    border-color: @navigation-border;
    background: fade(@navigation, 50%);
}

.zoom-pane-preview .zoom-pane-square.ui-draggable-dragging {
    border-color: @header-border;
    background: fade(@header, 50%);
}

.zoom-error-image{
    color: @content-text;
    span{
        color: @content-text;
    }
}

/* ==========================================================================
   Mixins
   ========================================================================== */

.gradient(@start: #EEE, @stop: #FFF) {
    background: @start;
    background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, @stop), color-stop(100%, @start));
    background-image: -webkit-linear-gradient(@stop, @start);
    background-image: -moz-linear-gradient(@stop, @start);
    background-image: -o-linear-gradient(@stop, @start);
    background-image: linear-gradient(@stop, @start);
}



@import "theme-client.css";

</div>
    </body>
</html>
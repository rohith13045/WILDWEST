default:
	@echo "type 'make docs' to get generate code documentation"

docs: 
	phpdoc -t ./webroot/docs -d . --sourcecode -p --ignore="*vendor*,*webroot*,*templates_c*,*memcadmin*"

buildconfig:
	@echo "making config file, please answer some questions."

	@read -p "please enter the db host:" dbhost; \
    read -p "please enter the db name:" dbname; \
    read -p "please enter the db username:" dbuser; \
    read -p "please enter the db password:" dbpass; \
	echo  "<?php \n\
/** \n\
* The Wild West FrameWork \n\
 * @copyright 2015 \n\
* \n\
* config options for system specific \n\
* This file is not included in vcs, it will need to be manualy created/generated for each build. \n\
* with the make buildconfig command, done in root directory of the framework. \n\
* \n\
*/ \n\
\n\
define('ENV', 'ENV_LOCAL'); \n\
define('WW_HOST', '$$dbhost'); \n\
define('WW_LOGIN', '$$dbname'); \n\
define('WW_PASS', '$$dbuser'); \n\
define('WW_DB', '$$dbpass'); \n\
define('CACHE_PREFIX', '_WLDWST_'); \n\
define('FIELD_PREFIX', '_WWfield_'); \n\
define('TABLE_PREFIX', '_WWtable_'); \n\
define('__LOG_DIRECTORY__',  dirname( __FILE__ ) . '/../logs/'); \n" > config/config.core.php


webview:
	@echo "Making new view, please answer some questions"
	@read -p "please enter the name of your new view:" viewname; \
	mkdir -p {views/$$viewname,views/$$viewname/templates_c,views/$$viewname/configs,views/$$viewname/cache,views/$$viewname/errors,webroot/$$viewname}; \
	touch views/$$viewname/errors/300.tpl; \
	touch controllers/$$viewname.controller.php; \
	touch models/$$viewname.model.php; \
	chmod 777 views/$$viewname/templates_c; chmod 777 views/$$viewname/cache; \
	echo "<?php \n\
/** \n\
* The Wild West FrameWork \n\
* @copyright 2015 \n\
* \n\
*/ \n\
\n\
\$$viewpath = basename(__DIR__); \n\
require_once( dirname(__FILE__).'/../../config/config.common.php'); \n\
Load::model(\"$$viewname\"); \n\
Load::controller(\"$$viewname\"); \n\
\n\
\n\
/** \n\
* Entry view object \n\
*/ \n\
\$$ViewObj = new __$$viewname(\"views/\$$viewpath\",\"webroot/\$$viewpath\",\$$_REQUEST['cache'],\$$_REQUEST['debug']); \n\
          if(isset(\$$_REQUEST['page'])){ \n\
           \n\
              \$$pagereq  = \"__\" . \$$_REQUEST['page']; \n\
              \$$params   = \$$_REQUEST; \n\
           \n\
              if (method_exists(\$$ViewObj, \"\$$pagereq\")) { \n\
                  \$$thepage = \$$ViewObj->\$$pagereq(\$$params); \n\
              }else{ \n\
          \n\
                  echo \"page object does not exist, exiting\"; \n\
                  exit; \n\
              } \n\
          \n\
          \n\
          }else{\n\
              \$$ViewObj->__default();\n\
          \n\
          }\n\
          \n\
\n"  > webroot/$$viewname/index.php


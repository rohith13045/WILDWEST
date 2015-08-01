default:
	@echo "type 'make docs' to get generate code documentation"

docs: 
	phpdoc -t ./webroot/docs -d . --sourcecode -p --ignore="*vendor*,*webroot*,*templates_c*,*memcadmin*"



webview:
	@echo "Making new view, please answer some questions"
	@read -p "please enter the name of your new view:" viewname; \
	set THEVIEW = "$viewnameModel"; \
	mkdir -vp views/$$viewname; \
	mkdir -vp views/$$viewname/templates_c; \
	mkdir -vp views/$$viewname/configs; \
	mkdir -vp views/$$viewname/cache; \
	mkdir -vp views/$$viewname/errors; \
	mkdir -vp webroot/$$viewname; \
	touch views/$$viewname/errors/300.tpl; \
	echo "$$viewname  template container" > views/$$viewname/$$viewname.tpl ; \
	#cp -v skel/skeleton.controller.php controllers/$$viewname.controller.php; \
	#cp -v skel/skeleton.model.php models/$$viewname.model.php; \
	chmod -v 777 views/$$viewname/templates_c; chmod 777 views/$$viewname/cache; \
	echo "<?php \n\
/** \n\
* The Wild West FrameWork \n\
* @copyright 2015 \n\
* \n\
*/ \n\
\n\
\$$viewpath = basename(__DIR__); \n\
require_once( dirname(__FILE__).'/../../config/config.common.php'); \n\
Load::model(\""$$viewname"\"); \n\
Load::controller(\""$$viewname"\"); \n\
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
\n"  > webroot/$$viewname/index.php; \
echo "<?php \n\
      /** \n\
       * The Wild West FrameWork \n\
       * @copyright 2015 \n\
       * \n\
       * $$viewname"Model" \n\
       * \n\
       * \n\
       * Class $$viewname \n\
       * Extends MasterDb \n\
       */ \n\
           \n\
      class $$viewname"Model"  extends MasterDb{ \n\
          use DBConfig; \n\
          use GeneralConfig; \n\
      \n\
      \n\
          public function __construct(\$$dsn, \$$user = \"\", \$$passwd = \"\"){ \n\
              \$$options = array( \n\
                  PDO::ATTR_PERSISTENT => true, \n\
                  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION \n\
              ); \n\
      \n\
              try { \n\
                  parent::__construct(\$$dsn, \$$user, \$$passwd, \$$options); \n\
              } catch (PDOException \$$e) { \n\
                  \$$this->error = \$$e->getMessage(); \n\
              } \n\
          } \n\
      \n\
          /** \n\
           * @return array \n\
           */ \n\
          public function show_db_status(){ \n\
              \$$status = parent::query_all(\"SHOW STATUS\"); \n\
              return(\$$status); \n\
          } \n\
      \n\
      \n\
      }\n\
\n" > models/$$viewname.model.php; \
echo "<?php  \n\
      /**     \n\
       * The Wild West FrameWork  \n\
       * @copyright 2015  \n\
       *  \n\
       * Class $$viewname  \n\
       * \n\
       */ \n\
       \n\
      class __$$viewname  extends SmartyView implements PageStruct { \n\
          /** \n\
           * use trait GeneralConfig \n\
           */ \n\
          use GeneralConfig; \n\
          /** \n\
           * use trait DBConfig \n\
           */ \n\
          use DBConfig; \n\
          /** \n\
           * @var string \n\
           */ \n\
          public \$$viewpath = ''; \n\
          /** \n\
           * @var \n\
           */ \n\
          public \$$smarty; \n\
       \n\
          /** \n\
           * @var \n\
           */ \n\
          private \$$dbObj; \n\
       \n\
          /** \n\
           * @var \n\
           */ \n\
          public \$$dateset; \n\
       \n\
          /** \n\
           * @var Logger \n\
           */ \n\
          private \$$logobj; \n\
       \n\
          /** \n\
           * @var \n\
           */ \n\
          public \$$sessionObj; \n\
       \n\
          /** \n\
           * @var \n\
           */ \n\
          public \$$login_check; \n\
       \n\
          /** \n\
           * @param string \$$viewp \n\
           * @param null \$$cache \n\
           * @param null \$$debug \n\
           */ \n\
          public function __construct(\$$viewp,\$$cache,\$$debug){ \n\
              parent::__construct(\$$viewp, \$$cache, \$$debug); \n\
              \$$this->dbObj                = new $$viewname"Model"(self::thedsn(\"mysql\"),self::theuser(),self::thepass()); \n\
              \$$this->sessionObj           = new DB_Session(self::mysqlIconnect(), 'x09Cod$_3CR&iT'); \n\
              \$$this->logobj               = new Logger(); \n\
              \$$this->viewpath             = \$$viewp; \n\
              \$$this->cache                = \$$cache; \n\
              \$$this->debugging            = \$$debug; \n\
              \$$this->dateset              = date('F j, Y, g:i a'); \n\
              \$$this->assign(\"dateset\",\$$this->dateset); \n\
              \$$this->login_check          = self::getSessionVar(\"LOGIN_CHECK\"); \n\
          } \n\
       \n\
          /** \n\
           * @return page default \n\
           */ \n\
          public function __default(){ \n\
              if (\$$this->login_check != \"OK\"){ \n\
                  header(\"location: /login/\"); \n\
              }else{ \n\
                  \$$this->assign(\"view_path\", \"/$$viewname\"); \n\
                  \$$this->global_header(); \n\
                  \$$this->display('$$viewname.tpl'); \n\
                  \$$this->global_footer(); \n\
              } \n\
          } \n\
       \n\
       \n\
          /** \n\
           * @return error page \n\
           * @param \$$code \n\
           */ \n\
          public function __error(\$$code,\$$msg){ \n\
              \$$this->assign(\"error_code\",\"\$$code\"); \n\
              \$$this->assign(\"msg\",\"\$$msg\"); \n\
              \$$this->display(\"errors/\$$code.tpl\"); \n\
          } \n\
       \n\
       \n\
      } \n\
 \n\
\n" > controllers/$$viewname.controller.php
<?php
    /**
     * commentator: Bogdan N. date: 31.07.2020
     * Application entry point.
     */

    // Global application constants
    define('ROOT_PATH', __DIR__);                                            # Project root directory.
    define('DATABASE_CONFIGURATION', __DIR__ . '/configuration/DbConf.php'); # The path to the database configuration file.

    // Importing application utilities files
    require_once ROOT_PATH . '/utilities/LogUtil.php';                       # Utility class for logs.
    require_once ROOT_PATH . '/utilities/ArrUtil.php';                       # Utility class for arrays.
    require_once ROOT_PATH . '/utilities/DbUtil.php';                        # Utility class for databases.

    // Importing application core files
    require_once ROOT_PATH . '/core/DatabaseManager.php';                    # Class for working with a database.
    require_once ROOT_PATH . '/core/BaseApiMethods.php';                     # An interface that contains the main API methods.
    require_once ROOT_PATH . '/core/BaseApiModel.php';                       # API class model.
    require_once ROOT_PATH . '/core/BaseApi.php';                            # An abstraction class that implements the basic functionality of the API.
    require_once ROOT_PATH . '/core/Router.php';                             # Router class.

    // Launch application
    Router::start();                                                         # Entry point.
<?php

use CodeIgniter\Controller;
use CodeIgniter\Router\RouteCollection;
use Config\Services;

// /**
//  * @var RouteCollection $routes
//  */
// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// setting default routing to controller 
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// controller/home method -> index
$routes->get('/', 'Home::index');

service('auth')->routes($routes);

// limitation of wich controller can be executed by level or group of user
// admin can creat category and user. expert can validate knowledge . User and expert can add knowledge and comment

// admin can do what user do, expert can do what user do.
$routes->group('KMS', ['filter' => 'session'], static function (RouteCollection $routes) {

    $routes->get('/', 'Dashboard\DashboardController');
    $routes->get('dashboard', 'Dashboard\DashboardController::dashboard');
    $routes->get('bidang', 'Dashboard\DashboardController::showbidang');
    $routes->post('summernote', 'Knowledge\TacitController::uploadGambar');
    $routes->delete('notedelete', 'Knowledge\TacitController::deleteGambar');
    // $routes->get('/tacitknowledge', 'Knowledge\KnowledgeController::showtacit')
    // $routes->get('/explicitknowledge', 'Knowledge\KnowledgeController::showexplicit')
    // $routes->get('/addtacitknowledge', 'Knowledge\KnowledgeController::addtacit')


    // -------------------------------------   TACIT START   --------------------------------------------------------------------

    // SHOW TACIT Knowledge
    $routes->get('tacit', 'Knowledge\TacitController::index');
    $routes->get('mytacit', 'Knowledge\TacitController::showmytacit');


    $routes->get('detailknowledge/(:segment)', 'Knowledge\TacitController::show/$1');
    $routes->post('addComment', 'Comment\CommentController::addComment');
    $routes->post('deleteComment/(:segment)', 'Comment\CommentController::deleteComment/$1');

    // $routes->resource('mytacit', ['controller'=> 'Knowledge\TacitController']) 

    // get form and post to database
    $routes->get('mytacit/new', 'Knowledge\TacitController::newtacit');
    $routes->post('mytacit', 'Knowledge\TacitController::create');

    //upload image on summernotes


    // get update form + existing data and update to database
    $routes->get('mytacit/(:segment)/edit', 'Knowledge\TacitController::edit/$1');
    $routes->put('mytacit/(:segment)/update', 'Knowledge\TacitController::update/$1');
    $routes->patch('mytacit/(:segment)/update', 'Knowledge\TacitController::update/$1');

    // delete knowledge 
    $routes->delete('mytacit/(:segment)', 'Knowledge\TacitController::delete/$1');




    // -----------------------------------------  EXPLICIT START    ------------------------------------------------------------

    // EXPLICIT Knowledge
    $routes->get('explicit', 'Knowledge\ExplicitController::index');
    $routes->get('myexplicit', 'Knowledge\ExplicitController::showmyexplicit');
    // $routes->get('myexplicit/(:segment)', 'Knowledge\ExplicitController::show/$1');
    // CREATE UPDATE DELETE EXPLICIT KNOWLEDGE
    // $routes->resource('myexplicit', ['controller'=> 'Knowledge\ExplicitController'])

    // get form and post to database
    $routes->get('myexplicit/new', 'Knowledge\ExplicitController::newexplicit');
    $routes->post('myexplicit', 'Knowledge\ExplicitController::create');

    // get update form + existing data and update to database
    $routes->get('myexplicit/(:segment)/edit', 'Knowledge\ExplicitController::edit/$1');
    $routes->put('myexplicit/(:segment)/update', 'Knowledge\ExplicitController::update/$1');
    $routes->patch('myexplicit/(:segment)/update', 'Knowledge\ExplicitController::update/$1');

    // delete knowledge 
    $routes->delete('myexplicit/(:segment)', 'Knowledge\ExplicitController::delete/$1');



    // ---------------------------------------- CATEGORY START    ---------------------------------------------------------------
    // Knowledge Category
    $routes->resource('knowledgecategory', ['controller' => 'Knowledge\CategoryController']);

    // // get list of category
    // $routes->get('knowledgecategory', 'Knowledge\CategoryController::index');
    // // get create category form, data is safe within validator, and post using createcategory function and redirect to list of category
    // $routes->get('knowledgecategory/newcategory', 'Knowledge\CategoryController::new');
    // $routes->post('knowledgecategory', 'Knowledge\CategoryController::createcategory');

    // // edit category
    // $routes->delete('knowledgecategory/(:segment)', 'Knowledge\CategoryController::deletecategory');
    // $routes->resource('category', ['controller' => 'Knowledge\CategoryController']);


    // --------------------------------------- VALIDATION EXPERT START  -----------------------------------------------------------

    $routes->get('unverified', 'Knowledge\ValidateKnowledgeController::index');
    $routes->get('unverified/(:segment)', 'Knowledge\ValidateKnowledgeController::show/$1');
    $routes->post('unverified/(:segment)', 'Knowledge\ValidateKnowledgeController::validating/$1');


    // ----------------------------------------    USER START   -------------------------------------------------------------------

    // USER //
    $routes->get('users/newuser', 'Users\RegisterController::index');
    $routes->post('users', 'Users\RegisterController::registerAction');

    $routes->resource('users', ['controller' => 'Users\UsersController']);
    
    $routes->get('profil/(:segment)/edit', 'Users\UsersController::editprofile/$1');
    $routes->put('profil/(:segment)/update', 'Users\UsersController::updateprofile/$1');
    $routes->patch('profil/(:segment)/update', 'Users\UsersController::updateprofile/$1');


    // EXPERT 
    $routes->get('expert/newexpert', 'Users\RegisterControllerExpert::index');
    $routes->post('expert', 'Users\RegisterControllerExpert::registerAction');

    $routes->get('admin/newadmin', 'Users\RegisterControllerAdmin::index');
    $routes->post('admin', 'Users\RegisterControllerAdmin::registerAction');




    // ----------------------------------    what else left???  ---------------------------------------------------------------------
    // ---------------------------------- should covered it all already   -----------------------------------------------------------
    // search knowledge             : 
    // add tacit,                   : 
    // show tacit,                  :                   HARDEST
    // update tacit,                :
    // delete tacit                 : 
    // add explicit,                :
    // show explicit,               :                   HARDEST
    // update explicit,             :
    // delete explicit,             :
    // download tacit knowledge     :
    // create comment               :                   HARDEST
    // delete comment               :  
    // add category,                : DONE
    // update category,             : DONE
    // delete category              : DONE
    // add user,                    : DONE
    // upadate user,                : DONE
    // delete user                  : DONE
    // add expert,                  : 
    // update expert,               :
    // delete expert                :
    // login                        : DONE
    // logout                       : DONE
    // 
});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

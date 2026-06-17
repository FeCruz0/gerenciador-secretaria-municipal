<?php

use App\Http\Controllers\AboutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExtensionController;

use App\Http\Controllers\PeopleController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AgreementTypeController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BiddingAgreementController;
use App\Http\Controllers\BiddingController;
use App\Http\Controllers\BiddingItemController;
use App\Http\Controllers\BiddingModalityController;
use App\Http\Controllers\BiddingWinnerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartamentController;
use App\Http\Controllers\DirectHireController;
use App\Http\Controllers\DirectHireWinnerController;
use App\Http\Controllers\DirectHireItemController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EntryReportsController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\LeadershipController;
use App\Http\Controllers\LegislationBondController;
use App\Http\Controllers\LegislationCategoryController;
use App\Http\Controllers\LegislationController;
use App\Http\Controllers\LegislationSituationController;
use App\Http\Controllers\LegislationSubjectController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OccupationController;
use App\Http\Controllers\OmbudsmanController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProjectCategoryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectMediaController;
use App\Http\Controllers\CoverageController;
use App\Http\Controllers\ConservationUnitController;
use App\Http\Controllers\ManagementReportTypeController;
use App\Http\Controllers\ManagementReportController;
use App\Http\Controllers\EnviromentalLicensingController;
use App\Http\Controllers\PostLicenseController;

use App\Http\Controllers\RevenueController;
use App\Http\Controllers\RevenueTypeController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TypeAccessController;
use App\Http\Controllers\TypeExpenseController;
use App\Http\Controllers\TypeRequestController;
use App\Http\Controllers\UserController;
use App\Models\DirectHireModality;


/*************************/
/* WEB CONTROLLERS */
/*************************/
use App\Http\Controllers\HomeWebController;
use App\Http\Controllers\InstitutionalWebController;
use App\Http\Controllers\ServicesWebController;
use App\Http\Controllers\MyEnvironmentWebController;
use App\Http\Controllers\PublicationWebController;
use App\Http\Controllers\TransparencyWebController;
use App\Http\Controllers\LegislationWebController;
use App\Http\Controllers\FAQWebController;
use App\Http\Controllers\UtilitiesWebController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\ShortcutWebController;


/*
|--------------------------------------------------------------------------
| Main Routes
|--------------------------------------------------------------------------
*/
//Ouvidoria - Ombudsman
Route::get('/ouvidoria_web', 'App\Http\Controllers\OmbudsmanController@web_ouvidoria')->name('web_ouvidoria');
Route::post('/ombudsman_store', 'App\Http\Controllers\OmbudsmanController@ombudsman_store')->name('ombudsman_store');

//Type Access -
Route::get('/type_access_select', 'App\Http\Controllers\TypeAccessController@select')->name('type_access_select');
//file
Route::get('/file_web/{file_id}', 'App\Http\Controllers\FileController@file_web')->name('file_web');
//Unit
Route::post('unidade_social_media_add', 'App\Http\Controllers\UnitController@unidade_social_media_add')->name('unidade_social_media_add');
Route::post('unidade_social_media_remove', 'App\Http\Controllers\UnitController@unidade_social_media_remove')->name('unidade_social_media_remove');
Route::post('unidade_social_media_update', 'App\Http\Controllers\UnitController@unidade_social_media_update')->name('unidade_social_media_update');
Route::get('unidade_social_media_delete/{social_media}', 'App\Http\Controllers\UnitController@unidade_social_media_delete')->name('unidade_social_media_delete');

/* Route admin não pode alterar*/
Route::group(['middleware' => ['auth']], function () {

    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');
    Route::get('analytics', [DashboardController::class, 'dashboardAnalytics'])->name('dashboard-analytics');

    Route::resource('permissions', PermissionsController::class);
    Route::delete('permissions_mass_destroy', 'App\Http\Controllers\Admin\PermissionsController@massDestroy')->name('permissions.mass_destroy');
    Route::resource('roles', RolesController::class);
    Route::delete('roles_mass_destroy', [RolesController::class, 'massDestroy'])->name('roles.mass_destroy');
    Route::resource('users', UsersController::class );
    Route::delete('users_mass_destroy', [UsersController::class, 'massDestroy'])->name('users.mass_destroy');
    Route::get('user_rule_create/{idUser}', [RolesController::class, 'user_rule_create'])->name('user_rule_create');
    Route::post('user_rule_store', [RolesController::class, 'user_rule_store'])->name('user_rule_store');


    //Main - Pessoas
    Route::resource('/pessoas', PeopleController::class);
    Route::resource('/telefones', PhoneController::class);
    Route::resource('/documentos', DocumentController::class);
    Route::resource('/emails', EmailController::class);
    Route::resource('/enderecos', AddressController::class);
    //Main - Departamentos
    Route::resource('/unidades', UnitController::class);
    Route::resource('/departamentos', DepartamentController::class);
    Route::resource('/organizacoes', OrganizationController::class);
    Route::resource('/ocupacoes', OccupationController::class);
    //Main - Arquivos
    Route::resource('/arquivos', FileController::class);
    //Main - Capa do site
    Route::resource('/capas', PostController::class);
    //Main - Notícias
    Route::resource('/noticias', NewsController::class);
    Route::resource('/noticia_categorias', CategoryController::class);
    Route::resource('/noticia_tags', TagController::class);
    //Main - Notificações
    Route::resource('/notificacoes', NotificationController::class);
    //Main - Ouvidoria ouvidoria_requisicoes
    Route::resource('/ouvidoria_manifestacoes', OmbudsmanController::class);
    Route::resource('/ouvidoria_acessos', TypeAccessController::class);
    Route::resource('/ouvidoria_requisicoes', TypeRequestController::class);
    //Main - Transparência - Despesas
    Route::resource('/despesa_tipos', TypeExpenseController::class);
    Route::resource('/despesas', ExpenseController::class);
    //Main - Transparência - Receitas
    Route::resource('/receita_tipos', RevenueTypeController::class);
    Route::resource('/receitas', RevenueController::class);
    //Main - Transparência - Legislações
    Route::resource('/legislacoes', LegislationController::class);
    Route::resource('/legislacao_assuntos', LegislationSubjectController::class);
    Route::resource('/legislacao_categorias', LegislationCategoryController::class);
    Route::resource('/legislacao_situacoes', LegislationSituationController::class);
    Route::resource('/legislacao_vinculos', LegislationBondController::class);
    //Main - Transparência - Licitações
    Route::resource('/licitacoes', BiddingController::class);
    Route::resource('/licitacao_modalidades', BiddingModalityController::class);
    Route::resource('/licitacao_items', BiddingItemController::class);
    Route::resource('/licitacao_vencedores', BiddingWinnerController::class);
    Route::resource('/licitacao_contratos', BiddingAgreementController::class);
    Route::resource('/licitacao_contrato_tipos', AgreementTypeController::class);
    //Main - Transparência - Contatações diretas
    Route::resource('/contratacoes_diretas', DirectHireController::class);
    Route::resource('/contratacao_direta_modalidades', DirectHireModality::class);
    Route::resource('/contratacao_direta_vencedores', DirectHireWinnerController::class);
    Route::resource('/contratacao_direta_itens', DirectHireItemController::class);
    //Main - Projetos
    Route::resource('/projetos', ProjectController::class);
    Route::resource('/projeto_categorias', ProjectCategoryController::class);
    Route::resource('/projeto_medias', ProjectMediaController::class);
    //Main - Unidades de Conservação
    Route::resource('/unid_conservacao', ConservationUnitController::class);
    Route::resource('/unid_conservacao_abrangencia', CoverageController::class);
    //Main - Relatório de Gestão
    Route::resource('/relatorio_de_gestao', ManagementReportController::class);
    Route::resource('/relatorio_de_gestao_tipo', ManagementReportTypeController::class);
    //Main - faq
    Route::resource('/faqs', FAQController::class);
    //Main - Gallery
    Route::resource('/galeria_imagens', GalleryController::class);
    //Main - Leadership
    Route::resource('/liderancas', LeadershipController::class);
    //Main - about
    Route::resource('/sobres', AboutController::class);
    //Main - Banner
    Route::resource('/banners', BannerController::class);
    //Main - Shortcutweb
    Route::resource('/web_atalhos', ShortcutWebController::class);
    //Main - Licenciamento Ambiental
    Route::resource('/licenciamento_ambiental', EnviromentalLicensingController::class);
    //Main - Pós Licença
    Route::resource('/pos_licenca', PostLicenseController::class);



    //Notícias
    //Route::post('ajaxRegister', ['as' => 'ajax.storecontent', 'uses' => 'App\Http\Controllers\NewsController@store_content']);
    Route::post('/savenewscontent', [NewsController::class, 'store_content'])->name('store_content');

    //people
    Route::get('store_people', [PeopleController::class, 'store_people'])->name('store_people');

    //Legislation Vínculo
    Route::post('legislacao_vinculo/{base}', [LegislationController::class, 'legislacao_vinculo'])->name('legislacao_vinculo');

    //Address
    Route::get('address/get-cidades/{idEstado}', 'App\Http\Controllers\AddressController@getCidades');
    //Notifications
    Route::get('notification/readed/{idNotification}', 'App\Http\Controllers\NotificationController@changeReaded');
    //departaments
    Route::get('departament/get-departamentos/{idUnit}', 'App\Http\Controllers\DepartamentController@getDepartamentos');
    Route::get('departament/get-occupations/{idDepartament}', 'App\Http\Controllers\DepartamentController@getOccupations');

    //licitação Vínculo de winner e itens
    Route::post('winner_add_itens/{person_id}', [BiddingWinnerController::class, 'winner_add_itens'])->name('winner_add_itens');
    Route::post('winner_remove_itens', [BiddingWinnerController::class, 'winner_remove_itens'])->name('winner_remove_itens');
    Route::get('winner_itens/{person_id}', [BiddingWinnerController::class, 'winner_itens'])->name('winner_itens');

    //news
    Route::get('/noticia_web/{new}', 'App\Http\Controllers\WebController@news_web_show')->name('news_web_show');
    Route::get('/noticias_web', 'App\Http\Controllers\WebController@news_web_index')->name('news_web_index');

    //reports ----------------------------- REPORTS -----------------------------------------------------------
    // --------------------------------------------------------------------------------------------------------

    // ombudsman
    Route::get('report_ombudsman_index', [OmbudsmanController::class, 'report_ombudsman_index'])->name('report_ombudsman_index');
    Route::post('report_ombudsman_pdf', [OmbudsmanController::class, 'report_ombudsman_pdf'])->name('report_ombudsman_pdf');

    //reports ----------------------------- Audits -----------------------------------------------------------
    // --------------------------------------------------------------------------------------------------------

    // entradas
    Route::get('entry_index', [EntryReportsController::class, 'entry_index'])->name('entry_index');

});
/* Route admin */

/* Route Usuarios */
Route::group(['middleware' => ['auth'], 'prefix' => 'usuarios'], function () {
    Route::post('/usuarios/update/password', [UserController::class, 'updatePassword'])->name('update-password');
    Route::post('/usuarios/update/email', [UserController::class, 'updateEmail'])->name('update-email');
    Route::post('/usuarios/update/photo', [UserController::class, 'updatePhoto'])->name('update-photo');
});
/* Route Usuarios */

/* Route Help */
Route::group(['middleware' => ['auth'], 'prefix' => 'help'], function () {
    Route::get('faq', [ExtensionController::class, 'faq'])->name('faq');
});
/* Route Help */


        /********************/
        /* WEB/SITE ROUTES */
        /********************/


//  ROTA HOME
Route::get('/', [HomeWebController::class, 'index'])->name('web_home');

//~ ROTAS INSTITUCIONAIS START ~~~
    // ROTA PROJETOS WEB
    Route::get('/projeto_web/{project_id}', [ProjectController::class, 'web_show'])->name('project_web_show');
    Route::get('/projeto_web', [ProjectController::class, 'web_index'])->name('projects_web_index');


    // UNIDADES DE CONSERVAÇÃO WEB
    Route::get('/unid_conservacao_web/{unid_consevacao_id}', [ConservationUnitController::class, 'web_show'])->name('unid_conservacao_web_show');
    Route::get('/unid_conservacao_web', [ConservationUnitController::class, 'web_index'])->name('unid_conservacao_web_index');

    // RELATÓRIO DE GESTÃO
    Route::get('/relatorio_de_gestao_web', [ManagementReportController::class, 'web_index'])->name('relatorio_de_gestao_web_index');

    // WEB TRANSPARÊNCIA
    Route::any('/despesas_index', 'App\Http\Controllers\ExpenseController@web_index')->name('web_expense_index');
    Route::get('/web_expense_show/{expense}', 'App\Http\Controllers\ExpenseController@web_show')->name('web_expense_show');
    Route::any('/receitas_index', 'App\Http\Controllers\RevenueController@web_index')->name('web_revenue_index');
    Route::get('/web_revenue_show/{revenue}', 'App\Http\Controllers\RevenueController@web_show')->name('web_revenue_show');
    Route::any('/legislacoes_index', 'App\Http\Controllers\LegislationController@index_web')->name('web_legislacoes_index');

    Route::get('/contratacao_direta_index', 'App\Http\Controllers\DirectHireController@index_web')->name('web_direct_hire_index');
    Route::get('/web_direct_hire_show/{direct_hire_id}', 'App\Http\Controllers\DirectHireController@show_web')->name('web_direct_hire_show');
    Route::get('/web_direct_hire_winner_show/{winner_id}', 'App\Http\Controllers\DirectHireWinnerController@show_web')->name('web_direct_hire_winner_show');
    Route::any('/licitacao_index', 'App\Http\Controllers\BiddingController@index_web')->name('web_bididng_index');
    Route::get('/web_bididng_show/{bididng}', 'App\Http\Controllers\BiddingController@show_web')->name('web_bididng_show');
    Route::any('/contratos_index', 'App\Http\Controllers\BiddingAgreementController@index_web')->name('web_bididng_agreement_index');
    Route::get('/web_bididng_agreement_show/{bidding_agreement_id}', 'App\Http\Controllers\BiddingAgreementController@show_web')->name('web_bididng_agreement_show');

    Route::get('/web_bididng_winner_show/{winner_id}', 'App\Http\Controllers\BiddingWinnerController@show_web')->name('web_bididng_winner_show');



    Route::prefix('institucional')->group(function(){
        Route::get('/asecretaria', [InstitutionalWebController::class, 'thesecretariat'])->name('web_institutional.thesecretariat');
        Route::get('/estrutura', [InstitutionalWebController::class, 'organstructure'])->name('web_institutional.organstructure');
        Route::get('/atendimento', [InstitutionalWebController::class, 'customerservice'])->name('web_institutional.customerservice');
    });

//~ ROTAS INSTITUCIONAIS END ~~~

//~ ROTAS DE SEVIÇOS START ~~~

    //  ROTA SERVIÇOS
    Route::prefix('servicos')->group(function(){
        Route::prefix('licenciamentoambiental')->group(function(){
            Route::get('/poslicenca', [ServicesWebController::class, 'postlicense'])->name('web_services.environmentlicensing.postlicense');
            Route::get('/checklist', [ServicesWebController::class, 'checklist'])->name('web_services.environmentlicensing.checklist');
            Route::get('/formularios', [ServicesWebController::class,'forms'])->name('web_services.environmentlicensing.forms');
        });
        Route::get('/fiscalizacao', [ServicesWebController::class, 'fiscalization'])->name('web_services.fiscalization');
        Route::get('/poda', [ServicesWebController::class, 'pruning'])->name('web_services.pruning');
        Route::get('/causaanimal', [ServicesWebController::class, 'animalcause'])->name('web_services.animalcause');
        Route::get('/protecaoambiental', [ServicesWebController::class, 'environmentprotection'])->name('web_services.environmentprotection');
        Route::get('/qualidadeambiental', [ServicesWebController::class, 'environmentquality'])->name('web_services.environmentquality');
        Route::get('/educacaoambiental', [ServicesWebController::class, 'environmenteducation'])->name('web_services.environmenteducation');

    // LICENCIAMENTO AMBIENTAL WEB
    Route::get('/licenciamento_ambiental_web', [EnviromentalLicensingController::class, 'web_index'])->name('licenciamento_ambiental_web');


    });

//~ ROTAS DE SEVIÇOS END ~~~

//~ ROTAS PROGRAMA MEU AMBIENTE ~~~


//~ ROTAS PROGRAMA MEU AMBIENTE END~~~


//~ ROTAS PUBLICAÇÕES ~~~

    // ROTA NOTICIAS

        Route::get('/noticias_web/{noticia_id}', [NewsController::class, 'web_show'])->name('noticia_web_show');
        Route::get('/noticias_web', [NewsController::class, 'web_index'])->name('noticias_web_index');

//~ ROTAS PUBLICAÇÕES END~~~




// ROTA OUVIDORIA
Route::get('/ouvidoria',[OmbudsmanController::class, 'web_ouvidoria'])->name('web_ombudsman');
Route::post('/ombudsman_store', [OmbudsmanController::class, 'ombudsman_store'])->name('ombudsman_store');

//  ROTA SERVIÇOS
Route::prefix('servicos')->group(function(){
    Route::prefix('licenciamentoambiental')->group(function(){
        Route::get('/',[ServicesWebController::class, 'environmentlicensing'])->name('web_services.environmentlicensing.home');
        Route::get('/poslicenca', [ServicesWebController::class, 'postlicense'])->name('web_services.environmentlicensing.postlicense');
        Route::get('/checklist', [ServicesWebController::class, 'checklist'])->name('web_services.environmentlicensing.checklist');
        Route::get('/formularios', [ServicesWebController::class,'forms'])->name('web_services.environmentlicensing.forms');
    });
    Route::get('/fiscalizacao', [ServicesWebController::class, 'fiscalization'])->name('web_services.fiscalization');
    Route::get('/poda', [ServicesWebController::class, 'pruning'])->name('web_services.pruning');
    Route::get('/causaanimal', [ServicesWebController::class, 'animalcause'])->name('web_services.animalcause');
    Route::get('/protecaoambiental', [ServicesWebController::class, 'environmentprotection'])->name('web_services.environmentprotection');
    Route::get('/qualidadeambiental', [ServicesWebController::class, 'environmentquality'])->name('web_services.environmentquality');
    Route::get('/educacaoambiental', [ServicesWebController::class, 'environmenteducation'])->name('web_services.environmenteducation');
});

//  ROTA PROGRAMA MEU AMBIENTE
Route::prefix('meuambiente')->group(function(){
    Route::get('/sobre', [MyEnvironmentWebController::class, 'about'])->name('web_myenvironment.about');
    Route::get('/politicaspublicas', [MyEnvironmentWebController::class, 'publicpolicy'])->name('web_myenvironment.publicpolicy');
    Route::get('/pilares', [MyEnvironmentWebController::class, 'pillars'])->name('web_myenvironment.pillars');
    Route::get('/campanhas', [MyEnvironmentWebController::class, 'campaign'])->name('web_myenvironment.campaign');
});

//  ROTA PUBLICAÇÃO
Route::prefix('publicacao')->group(function(){
    Route::get('/publicacoes',[PublicationWebController::class, 'home'])->name('web_publication.home');
    Route::get('/pesquisas',[PublicationWebController::class, 'researchs'])->name('web_publication.researchs');
});

//  ROTA TRANSPARÊNCIA
Route::prefix('transparencia')->group(function(){
    Route::get('/portaltransparencia', [TransparencyWebController::class, 'portal'])->name('web_transparency.portal');
    Route::get('/conselhoambiente', [TransparencyWebController::class, 'environmentcouncil'])->name('web_transparency.environmentcouncil');
    Route::get('/outrosconselhos', [TransparencyWebController::class, 'councilparticipation'])->name('web_transparency.councilparticipation');
    Route::get('/fundoambiente', [TransparencyWebController::class, 'environmentfund'])->name('web_transparency.environmentfund');
    Route::get('/ajusteambiental', [TransparencyWebController::class, 'environmentaladjustment'])->name('web_transparency.environmentaladjustment');
});

//  ROTA LEGISLAÇÃO
Route::get('/legislacao', [LegislationController:: class, 'show_web'])->name('web_legislation_show');

//ROTA FAQ
Route::get('/faq', [FAQWebController::class, 'index'])->name('web_faq');

//ROTA UTILIDADES - BALNEABILIDADE DE PRAIAS
Route::prefix('utilidades')->group(function(){
    Route::get('/balneabilidadepraias', [UtilitiesWebController::class, 'balneabilityofbeaches'])->name('web_utilities.balneabilityofbeaches');
});

//

/********************/

/* END WEB/SITE ROUTES */
/***********************/


require __DIR__.'/auth.php';
require __DIR__.'/dev.php';
require __DIR__.'/filters.php';
require __DIR__.'/reports.php';

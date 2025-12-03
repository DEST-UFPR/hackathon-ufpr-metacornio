<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViewsController;
use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\ImportPesquisaController;
use App\Http\Controllers\TabelaGeralController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

# Pagina Inicial
Route::get('/', [ViewsController::class, 'index'])->name('index');
Route::get('/relatorio-avaliacao-disciplina', [ViewsController::class, 'relDisciplina'])->name('relDisciplina');
Route::get('/relatorio-avaliacao-curso', [ViewsController::class, 'relCurso'])->name('relCurso');
Route::get('/relatorio-avaliacao-instituicao', [ViewsController::class, 'relInstituicao'])->name('relInstituicao');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

# Rotas Views com Validação
Route::middleware(['auth:web'])->group(function (){
    # Paginas do Painel
    Route::get('/painel', [ViewsController::class, 'painel'])->name('painel');
    Route::get('/avaliacao', [ViewsController::class, 'avaliacao'])->name('avaliacao');
    Route::get('/importar-pesquisa', [ViewsController::class, 'importarPesquisa'])->name('importarPesquisa');
    Route::get('/dados-gerais', [ViewsController::class, 'tabelaGeral'])->name('tabelaGeral');
    Route::get('/usuario', [ViewsController::class, 'usuario'])->name('usuario');
    Route::get('/estatistica-alerta', [ViewsController::class, 'estatisticaAlerta'])->name('estatisticaAlerta');

    # CRUD Avaliação
    Route::get('/get-avaliacao', [AvaliacaoController::class, 'getAll'])->name('getAvaliacoes');
    Route::get('/get-avaliacao/{id?}', [AvaliacaoController::class, 'getAvaliacao'])->name('getAvaliacao');
    Route::post('/get-avaliacao-completa', [AvaliacaoController::class, 'getAvaliacaoCompleto'])->name('getAvaliacaoCompleto');
    Route::post('/new-avaliacao', [AvaliacaoController::class, 'newAvaliacao'])->name('newAvaliacao');
    Route::post('/update-avaliacao', [AvaliacaoController::class, 'updateAvaliacao'])->name('updateAvaliacao');
    Route::post('/delete-avaliacao', [AvaliacaoController::class, 'deleteAvaliacao'])->name('deleteAvaliacao');

    # CRUD Importação de Pesquisa
    Route::get('/get-import-pesquisa', [ImportPesquisaController::class, 'getAll'])->name('getImportPesquisas');
    Route::get('/get-import-pesquisa/{id?}', [ImportPesquisaController::class, 'getImportPesquisa'])->name('getImportPesquisa');
    Route::post('/get-import-pesquisa-completa', [ImportPesquisaController::class, 'getImportPesquisaCompleto'])->name('getImportPesquisaCompleto');
    Route::post('/save-import-pesquisa', [ImportPesquisaController::class, 'newImportPesquisa'])->name('newImportPesquisa');
    Route::post('/delete-import-pesquisa', [ImportPesquisaController::class, 'deleteImportPesquisa'])->name('deleteImportPesquisa');

    # CRUD Tabela Geral
    Route::get('/get-tabela-geral', [TabelaGeralController::class, 'getAll'])->name('getTabelaGerais');
    Route::get('/get-tabela-geral/{id?}', [TabelaGeralController::class, 'getTabelaGeral'])->name('getTabelaGeral');
    Route::post('/get-tabela-geral-completa', [TabelaGeralController::class, 'getTabelaGeralCompleto'])->name('getTabelaGeralCompleto');
    Route::post('/new-tabela-geral', [TabelaGeralController::class, 'newTabelaGeral'])->name('newTabelaGeral');
    Route::post('/update-tabela-geral', [TabelaGeralController::class, 'updateTabelaGeral'])->name('updateTabelaGeral');
    Route::post('/delete-tabela-geral', [TabelaGeralController::class, 'deleteTabelaGeral'])->name('deleteTabelaGeral');

    # CRUD Usuário
    Route::get('/get-usuario', [UserController::class, 'getAll'])->name('getUsuarios');
    Route::get('/get-usuario/{id?}', [UserController::class, 'getUsuario'])->name('getUsuario');
    Route::post('/get-usuario-completa', [UserController::class, 'getUsuarioCompleto'])->name('getUsuarioCompleto');
    Route::post('/new-usuario', [UserController::class, 'newUsuario'])->name('newUsuario');
    Route::post('/update-usuario', [UserController::class, 'updateUsuario'])->name('updateUsuario');
    Route::post('/update-usuario-senha', [UserController::class, 'updateUsuarioPassword'])->name('updateUsuarioPassword');
    Route::post('/delete-usuario', [UserController::class, 'deleteUsuario'])->name('deleteUsuario');
});

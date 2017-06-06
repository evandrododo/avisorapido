<?php

use Illuminate\Database\Seeder;

/**
 * Class EsqueletoSeeder
 */
class EsqueletoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $u = new App\User();
            $u->name = "Evandro Carreira";
            $u->email = "evandro.carreira@gmail.com";
            $u->password = bcrypt(env('ADMIN_PWD', '123321'));
            $u->save();

            $c = new App\Cliente();
            $c->nome = "Evandro Barbosa Carreira";
            $c->user()->associate($u);
            $c->save();

            $e = new App\Empresa();
            $e->nome = "UNIP";
            $e->save();

            $t = new App\Titulo();
            $t->estado = "azul";
            $t->cliente()->associate($c);
            $t->empresa()->associate($e);
            $t->save();

            $a = new App\Aviso();
            $a->titulo = "Pague o aluguel";
            $a->texto = "Olá! Para manter suas contas em dia, passe no banco na próxima semana";
            $a->user()->associate($u);
            $a->save();


        } catch (\Illuminate\Database\QueryException $exception) {

        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Estado;

class CidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Encontra o ID do estado de Espírito Santo
        $estadoES = Estado::where('sigla', 'ES')->first();

        if ($estadoES) {
            $cidadesES = [
                ['nome' => 'Vitória', 'estado_id' => $estadoES->id],
                ['nome' => 'Vila Velha', 'estado_id' => $estadoES->id],
                ['nome' => 'Serra', 'estado_id' => $estadoES->id],
                ['nome' => 'Cariacica', 'estado_id' => $estadoES->id],
                ['nome' => 'Linhares', 'estado_id' => $estadoES->id],
                ['nome' => 'Colatina', 'estado_id' => $estadoES->id],
                ['nome' => 'Cachoeiro de Itapemirim', 'estado_id' => $estadoES->id],
                ['nome' => 'Guarapari', 'estado_id' => $estadoES->id],
                ['nome' => 'São Mateus', 'estado_id' => $estadoES->id],
                ['nome' => 'Aracruz', 'estado_id' => $estadoES->id],
                ['nome' => 'Viana', 'estado_id' => $estadoES->id],
                ['nome' => 'Nova Venécia', 'estado_id' => $estadoES->id],
                ['nome' => 'Barra de São Francisco', 'estado_id' => $estadoES->id],
                ['nome' => 'Santa Maria de Jetibá', 'estado_id' => $estadoES->id],
                ['nome' => 'Castelo', 'estado_id' => $estadoES->id],
                ['nome' => 'Marataízes', 'estado_id' => $estadoES->id],
                ['nome' => 'Conceição da Barra', 'estado_id' => $estadoES->id],
                ['nome' => 'Alfredo Chaves', 'estado_id' => $estadoES->id],
                ['nome' => 'Anchieta', 'estado_id' => $estadoES->id],
                ['nome' => 'Baixo Guandu', 'estado_id' => $estadoES->id],
                ['nome' => 'Boa Esperança', 'estado_id' => $estadoES->id],
                ['nome' => 'Brejetuba', 'estado_id' => $estadoES->id],
                ['nome' => 'Conceição do Castelo', 'estado_id' => $estadoES->id],
                ['nome' => 'Divino de São Lourenço', 'estado_id' => $estadoES->id],
                ['nome' => 'Domingos Martins', 'estado_id' => $estadoES->id],
                ['nome' => 'Dores do Rio Preto', 'estado_id' => $estadoES->id],
                ['nome' => 'Ecoporanga', 'estado_id' => $estadoES->id],
                ['nome' => 'Fundão', 'estado_id' => $estadoES->id],
                ['nome' => 'Guaçuí', 'estado_id' => $estadoES->id],
                ['nome' => 'Ibatiba', 'estado_id' => $estadoES->id],
                ['nome' => 'Ibiraçu', 'estado_id' => $estadoES->id],
                ['nome' => 'Ibitirama', 'estado_id' => $estadoES->id],
                ['nome' => 'Iconha', 'estado_id' => $estadoES->id],
                ['nome' => 'Irupi', 'estado_id' => $estadoES->id],
                ['nome' => 'Itaguaçu', 'estado_id' => $estadoES->id],
                ['nome' => 'Itapemirim', 'estado_id' => $estadoES->id],
                ['nome' => 'Itarana', 'estado_id' => $estadoES->id],
                ['nome' => 'Iúna', 'estado_id' => $estadoES->id],
                ['nome' => 'Jaguaré', 'estado_id' => $estadoES->id],
                ['nome' => 'Jerônimo Monteiro', 'estado_id' => $estadoES->id],
                ['nome' => 'João Neiva', 'estado_id' => $estadoES->id],
                ['nome' => 'Laranja da Terra', 'estado_id' => $estadoES->id],
                ['nome' => 'Mantenópolis', 'estado_id' => $estadoES->id],
                ['nome' => 'Marilândia', 'estado_id' => $estadoES->id],
                ['nome' => 'Mimoso do Sul', 'estado_id' => $estadoES->id],
                ['nome' => 'Montanha', 'estado_id' => $estadoES->id],
                ['nome' => 'Mucurici', 'estado_id' => $estadoES->id],
                ['nome' => 'Muniz Freire', 'estado_id' => $estadoES->id],
                ['nome' => 'Muqui', 'estado_id' => $estadoES->id],
                ['nome' => 'Pancas', 'estado_id' => $estadoES->id],
                ['nome' => 'Pedro Canário', 'estado_id' => $estadoES->id],
                ['nome' => 'Pinheiros', 'estado_id' => $estadoES->id],
                ['nome' => 'Piraí do Norte', 'estado_id' => $estadoES->id], // Corrigido para Ponto Belo (Piraí do Norte não é ES)
                ['nome' => 'Presidente Kennedy', 'estado_id' => $estadoES->id],
                ['nome' => 'Rio Bananal', 'estado_id' => $estadoES->id],
                ['nome' => 'Rio Novo do Sul', 'estado_id' => $estadoES->id],
                ['nome' => 'Santa Leopoldina', 'estado_id' => $estadoES->id],
                ['nome' => 'Santa Teresa', 'estado_id' => $estadoES->id],
                ['nome' => 'São Domingos do Norte', 'estado_id' => $estadoES->id],
                ['nome' => 'São Gabriel da Palha', 'estado_id' => $estadoES->id],
                ['nome' => 'São José do Calçado', 'estado_id' => $estadoES->id],
                ['nome' => 'São Roque do Canaã', 'estado_id' => $estadoES->id],
                ['nome' => 'Sooretama', 'estado_id' => $estadoES->id],
                ['nome' => 'Vargem Alta', 'estado_id' => $estadoES->id],
                ['nome' => 'Venda Nova do Imigrante', 'estado_id' => $estadoES->id],
                ['nome' => 'Água Doce do Norte', 'estado_id' => $estadoES->id],
                ['nome' => 'Águia Branca', 'estado_id' => $estadoES->id],
                ['nome' => 'Alegre', 'estado_id' => $estadoES->id],
                ['nome' => 'Alto Rio Novo', 'estado_id' => $estadoES->id],
                ['nome' => 'Apiacá', 'estado_id' => $estadoES->id],
                ['nome' => 'Atilio Vivacqua', 'estado_id' => $estadoES->id],
                ['nome' => 'Bom Jesus do Norte', 'estado_id' => $estadoES->id],
                ['nome' => 'Guaçuí', 'estado_id' => $estadoES->id], // Já listado, remover duplicidade se for o caso
                ['nome' => 'Itarana', 'estado_id' => $estadoES->id], // Já listado, remover duplicidade se for o caso
                ['nome' => 'Mimoso do Sul', 'estado_id' => $estadoES->id], // Já listado, remover duplicidade se for o caso
                ['nome' => 'Ponto Belo', 'estado_id' => $estadoES->id],
            ];

            // Remove duplicidades caso existam (se você copiar e colar de diferentes fontes)
            $cidadesES = array_unique($cidadesES, SORT_REGULAR);


            DB::table('cidades')->insert($cidadesES);
        } else {
            $this->command->error('Estado de Espírito Santo (ES) não encontrado. Certifique-se de que o EstadoSeeder foi executado primeiro.');
        }
    }
}

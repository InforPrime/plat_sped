<?php

namespace App\Http\Controllers;

use App\Models\Arquivo;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ArquivoController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'arquivo' => 'required|file'
        ]);

        $arquivo = $request->file('arquivo');
        $nomeArquivo = $arquivo->getClientOriginalName();

        // Salva o arquivo
        $arquivo->storeAs('speds', $nomeArquivo);

        // Busca o cliente com base no nome_modelo contido no nome do arquivo
        $cliente = Cliente::whereRaw('? LIKE CONCAT("%", nome_modelo, "%")', [$nomeArquivo])->first();

        if (!$cliente) {
            return response()->json([
                'message' => 'Cliente não encontrado para este arquivo.'
            ], 404);
        }

        // Cria o registro do arquivo
        Arquivo::create([
            'cliente_id' => $cliente->id,
            'nome' => $nomeArquivo,
            'caminho' => 'speds/' . $nomeArquivo
        ]);

        return response()->json([
            'message' => 'Arquivo enviado com sucesso'
        ]);
    }
}

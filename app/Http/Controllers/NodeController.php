<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Proxmox\Proxmox; // 1. Importe a classe da biblioteca Proxmox

class NodeController extends Controller
{
    // 2. Crie uma propriedade para guardar o cliente da API
    protected $proxmox;

    /**
     * 3. Crie o construtor para receber a injeção de dependência.
     * O Laravel vai automaticamente criar e passar o objeto Proxmox aqui.
     */
    public function __construct(Proxmox $proxmox)
    {
        $this->proxmox = $proxmox;
    }

    /**
     * Exibe uma lista de todos os nodes do cluster.
     */
    public function index()
    {
        try {
            // 4. Agora você pode usar o cliente da API em qualquer método!
            $nodes = $this->proxmox->nodes()->get();

            // Envie os dados para a view (certifique-se de criar a view mais tarde)
            return view('nodes.index', [
                'nodes' => $nodes['data']
            ]);

        } catch (\Exception $e) {
            // Em caso de falha na API, redirecione de volta com um erro
            return back()->withErrors('Falha ao comunicar com a API do Proxmox: ' . $e->getMessage());
        }
    }

    /**
     * Exibe informações detalhadas de um node específico.
     */
    public function show(string $nodeId)
    {
        // Exemplo de como você usaria em outro método
        try {
            $nodeStatus = $this->proxmox->nodes($nodeId)->status()->get();
            dd($nodes); // <--- ADICIONE ESTA LINHA

            return view('nodes.show', [
                'nodeId' => $nodeId,
                'status' => $nodeStatus['data']
            ]);

        } catch (\Exception $e) {
            return back()->withErrors('Falha ao buscar status do node: ' . $e->getMessage());
        }
    }
}
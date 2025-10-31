<?php

namespace App\Http\Controllers;
use App\Models\Notificacao;
use Illuminate\Http\Request;

class NotificacaoController extends Controller
{
    public function index()
    {
        $notificacoes = Notificacao::where('user_id', auth()->id())
            ->with('destinatario')
            ->latest()
            ->get();

        return view('notificacoes.index', compact('notificacoes'));
    }

    public function json()
    {
        $notificacoes = Notificacao::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'label' => $notificacoes->whereNull('data_leitura')->count(),
            'label_color' => 'danger',
            'icon_color' => 'warning',
            'update_mode' => 'replace',
            'items' => $notificacoes->map(function ($n) {
                return [
                    'id' => $n->id,
                    'text' => $n->titulo,
                    'time' => $n->created_at->diffForHumans(),
                    'class' => is_null($n->data_leitura) ? 'bg-light' : '',
                    'icon' => 'fas fa-bell',
                    'url' => route('notificacoes.show', $n->id),
                ];
            }),
        ]);
    }


    public function show($id)
    {
        $notificacao = Notificacao::with('destinatario')->findOrFail($id);
        return view('notificacoes.show', compact('notificacao'));
    }

    public function marcarComoLida($id)
    {
        $notificacao = Notificacao::where('user_id', auth()->id())->findOrFail($id);
        $notificacao->update(['data_leitura' => now()]);

        return redirect()->back()->with('success', 'Notificação marcada como lida.');
    }
}

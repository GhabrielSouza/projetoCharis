<?php

namespace App\Http\Controllers;
use App\Models\Notificacao;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NotificacaoController extends Controller
{
    public function index()
    {
        $notificacoes = Notificacao::where('user_id', auth()->id())
            ->with('destinatario')
            ->latest()
            ->paginate(10);

        return view('notificacoes', compact('notificacoes'));
    }

    public function json()
    {
        $userId = auth()->id() ?? 1;

        $notificacoes = Notificacao::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $dropdownHtml = '';

        foreach ($notificacoes as $key => $n) {
            $text = Str::limit($n->titulo, 15);
            $icon = "<i class='fas fa-birthday-cake text-warning'></i>";

            $time = "<span class='float-right text-muted text-sm'>"
                . $n->created_at->diffForHumans()
                . "</span>";

            $dropdownHtml .= "<a href='" . route('notificacoes.show', $n->id) . "'
                           class='dropdown-item'>
                            {$icon}{$text}{$time}
                          </a>";

            if ($key < count($notificacoes) - 1) {
                $dropdownHtml .= "<div class='dropdown-divider'></div>";
            }
        }

        // Retorna o formato esperado
        return [
            'label' => $notificacoes->whereNull('data_leitura')->count(),
            'label_color' => 'danger',
            'icon_color' => 'dark',
            'dropdown' => $dropdownHtml,
        ];
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

    public function marcarTodasComoLida()
    {
        Notificacao::where('user_id', auth()->id())
            ->whereNull('data_leitura')
            ->update(['data_leitura' => now()]);

        return back();
    }
}

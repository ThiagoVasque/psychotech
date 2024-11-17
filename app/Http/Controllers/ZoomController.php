<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class ZoomController extends Controller
{
    public function handleCallback(Request $request)
    {
        
        if ($request->has('code')) {
            $code = $request->get('code');
            
            // Configuração do OAuth
            $clientId = env('ZOOM_CLIENT_ID');
            $clientSecret = env('ZOOM_CLIENT_SECRET');
            $redirectUri = env('ZOOM_REDIRECT_URI');
            
            $response = Http::asForm()->post('https://zoom.us/oauth/token', [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => $redirectUri,
            ], [
                'Authorization' => 'Basic ' . base64_encode($clientId . ':' . $clientSecret),
            ]);
            
            // Verificar a resposta
            if ($response->successful()) {
                $data = $response->json();
                
                // Armazenar o token de acesso e refresh token
                $accessToken = $data['access_token'];
                $refreshToken = $data['refresh_token'];
                
                // Aqui você pode armazenar os tokens no banco de dados ou na sessão
                session(['zoom_access_token' => $accessToken]);
                session(['zoom_refresh_token' => $refreshToken]);
                
                return redirect()->route('zoom.success'); // Redirecionar para uma página de sucesso
            } else {
                // Se a resposta for falha
                return redirect()->route('error_page')->with('error', 'Erro ao autenticar com o Zoom.');
            }
        } else {
            return redirect()->route('error_page')->with('error', 'Código não encontrado.');
        }
    }

    private function criarReuniaoZoom($consulta)
    {
        $client = new Client();
        
        // Usando o token de acesso da sessão
        $accessToken = session('zoom_access_token');
        
        if (!$accessToken) {
            return redirect()->route('error_page')->with('error', 'Token de acesso não encontrado.');
        }

        $response = $client->post('https://api.zoom.us/v2/users/me/meetings', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'topic' => 'Consulta: ' . $consulta->id,
                'type' => 2, 
                'start_time' => $consulta->data_hora->toIso8601String(), 
                'duration' => 30, 
                'timezone' => 'America/Sao_Paulo',
                'agenda' => 'Consulta com o paciente.',
                'settings' => [
                    'host_video' => true,
                    'participant_video' => true,
                    'join_before_host' => true,
                    'mute_upon_entry' => true,
                    'audio' => 'voip', 
                ],
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        // Atualizando a consulta com o link da reunião
        $consulta->link_doutor = $data['join_url'];  
        $consulta->link_paciente = $data['join_url']; 
        $consulta->save();

        return $data;
    }

    public function entrarVideochamadaPaciente($consultaId)
    {
        $consulta = Consulta::findOrFail($consultaId);
        $paciente = Auth::guard('paciente')->user();

        // Verificar se o paciente está correto
        if ($consulta->paciente_cpf != $paciente->cpf) {
            return redirect()->route('paciente.consultas')->with('error', 'Você não tem permissão para acessar essa videochamada.');
        }

        // Criar a reunião se necessário
        if (empty($consulta->link_paciente)) {
            $this->criarReuniaoZoom($consulta);
        }

        return response()->json(['link' => $consulta->link_paciente]);
    }

    public function entrarVideochamadaDoutor($consultaId)
    {
        $consulta = Consulta::findOrFail($consultaId);
        $doutor = Auth::guard('doutor')->user();

        // Verificar se o doutor está correto
        if ($consulta->doutor_cpf != $doutor->cpf) {
            return redirect()->route('doutor.consultas')->with('error', 'Você não tem permissão para acessar essa videochamada.');
        }
        if (empty($consulta->link_doutor)) {
            $this->criarReuniaoZoom($consulta);
        }

        return response()->json(['link' => $consulta->link_doutor]);
    }
}

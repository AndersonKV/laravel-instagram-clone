<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Hash;



class UploadController extends Controller
{
    public function uploadUser(Request $request)
    {

        $user = Auth::user();


        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($user->image) {
                $name = $user->image;
            } else {
                $name = $user->id . kebab_case($user->name);
            }

            // Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));

            // Recupera a extensão do arquivo
            $extension = $request->image->extension();

            // Define finalmente o nome
            $nameFile = "{$name}.{$extension}";
            // Faz o upload:
            $upload = $request->image->storeAs('upload', $nameFile);

            // Verifica se NÃO deu certo o upload (Redireciona de volta)
            if (!$upload) {
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer upload')
                    ->withInput();
            }

            //salva no banco de dados o nome da imagem
            $user->image = $nameFile;
            $user->save();
            return redirect()->back();
        }
    }
}

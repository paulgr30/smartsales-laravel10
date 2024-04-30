<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Http\Requests\ConfigRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConfigurationController extends Controller
{
    public function getAll()
    {
        $resource = Configuration::first();
        return response()->json($resource);
    }

    public function getImageUrl()
    {
        $resource = Configuration::first();
        return response()->json($resource->image_url);
    }

    public function update(ConfigRequest $request, Configuration $config)
    {
        //Storage::delete($config->image_url);
        $dataValidated = $request->validated();

        // Verificamos si hay un archivo(imagen)
        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            // Almacenamos la imagen en el storage y obtenemos su ruta
            $path = Storage::disk('public')->put('/', $image);
            // Verificamos si ya se tiene una imagen
            if ($config->image_url) {
                // Eliminamos la imagen actual
                Storage::disk('public')->delete($config->image_url);
                // Agregamos la url de la imagen al array
                $dataValidated['image_url'] = $path;
            }
        }
        $config->update($dataValidated);
        return response()->json(['message' => 'Operacion realizada con exito']);
    }
}

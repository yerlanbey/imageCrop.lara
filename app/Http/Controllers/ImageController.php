<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        // Делаем валидацию данных обе инпуты обязательны
        $request->validate([
            'name' => 'required',
            'image' => 'required',
        ]);
        //Получаем все данные с формы
        $parametrs = $request->all();
        //Исключаем токен @csrf
        unset($parametrs['_token']);
        //Получаем файл и временно сохр его в Storage в папке image
        $imagePath = $request->file('image')->store('image/');
        //Меняем размер фото там где он находится на width:200 height:300 пикселей
        $image = Image::make(public_path("storage/{$imagePath}"))->
        resize(200, 300);
        //Сохраняем
        $image->save(public_path("storage/{$imagePath}"), 60);
        $image->save();
        //Создаем в БД
        //Делаем редайрект при успешном выполнений
        if(        Post::create([
            'name' => $request['name'],
            'image' => $imagePath
        ])){
            return redirect()->back()->with('success', 'Успешно отправлено!');
        }else{
            return redirect()->back()->with('warning', 'Что то пошло не так!');
        }

    }

    public function index()
    {
        $posts = Post::get();
        return view('index', compact('posts'));
    }
}

<?php
namespace App\Controllers;


class TestController extends Controller
{
    public function index()
    {
        $this->render('test/index');
    }

    public function test($params=null)
    {
        var_dump($params);
        $test = ['id'=> 4, 'content'=>"Bonjour on fait un test devant la classe"];
        $this->render('test/test',compact('test'));
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\Label;
use App\Models\User;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = [
            [
                'name' => 'Исправить ошибку в какой-нибудь строке',
                'description' => 'Я тут ошибку нашёл, надо бы её исправить и так далее и так далее'
            ],
            [
                'name' => 'Допилить дизайн главной страницы',
                'description' => 'Вёрстка поехала в далёкие края. Нужно удалить бутстрап!'
            ],
            [
                'name' => 'Отрефакторить авторизацию',
                'description' => 'Выпилить всё легаси, которое найдёшь'
            ],
            [
                'name' => 'Доработать команду подготовки БД',
                'description' => 'За одно добавить тестовых данных'
            ],
            [
                'name' => 'Пофиксить вон ту кнопку',
                'description' => 'Кажется она не того цвета'
            ],
            [
                'name' => 'Исправить поиск',
                'description' => 'Не ищет то, что мне хочется'
            ],
            [
                'name' => 'Добавить интеграцию с облаками',
                'description' => 'Они такие мягкие и пушистые'
            ],
            [
                'name' => 'Выпилить лишние зависимости',
                'description' => ''
            ],
            [
                'name' => 'Запилить сертификаты',
                'description' => 'Кому-то же они нужны?'
            ],
            [
                'name' => 'Выпилить игру престолов',
                'description' => 'Этот сериал никому не нравится! :)'
            ],
            [
                'name' => 'Пофиксить спеку во всех репозиториях',
                'description' => 'Передать Олегу, чтобы больше не ронял прод'
            ],
            [
                'name' => 'Вернуть крошки',
                'description' => 'Андрей, это задача для тебя'
            ],
            [
                'name' => 'Установить Linux',
                'description' => 'Не забыть потестировать'
            ],
            [
                'name' => 'Потребовать прибавки к зарплате',
                'description' => 'Кризис это не время, чтобы молчать!'
            ],
            [
                'name' => 'Добавить поиск по фото',
                'description' => 'Только не по моему'
            ],
            [
                'name' => 'Съесть еще этих прекрасных французских булочек',
                'description' => ''
            ],
        ];

        for ($i = 0; $i < count($tasks); $i++) {
            if (!Task::firstWhere('name', $tasks[$i]['name'])) {
                Task::create([
                    'name' => $tasks[$i]['name'],
                    'description' => $tasks[$i]['description'],
                    'status_id' => TaskStatus::inRandomOrder()->first()->id,
                    'created_by_id' => User::inRandomOrder()->first()->id,
                    'assigned_to_id' => User::inRandomOrder()->first()->id,
                ]);
            }
        }

        Task::all()->each(function ($task) {
            $labels = Label::inRandomOrder()
                ->limit(rand(1, Label::count()))
                ->get();
            $task->labels()->attach($labels);
        });
    }
}

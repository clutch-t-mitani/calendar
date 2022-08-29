<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;

class ReserveTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    //ログインユーザーがカレンダー予約画面にログインできること(200)
    public function test_calendar_index_ok()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get("/calendar/2022-08-18%2010:00:00");
        // $response->assertStatus(200);
        $response->assertStatus(Response::HTTP_OK);
    }

    // ログインしていないユーザがカレンダー予約画面にアクセスできないこと(リダイレクトされる)
    public function test_calendar_index_ng()
    {
        $response = $this->get('/calendar/2022-08-18%2010:00:00');
        $response->assertStatus(302);
    }

    //存在しない予約画面にアクセスできないこと(リダイレクトされる)
    public function test_calendar_not_id_ng()
    {
        $user = User::factory()->create();

        $response = $this->get('/calendar/dasasdsdddaddsadasdsd');
        $response->assertStatus(302);
    }

    //正しいメニューIDで予約が行える事
    public function test_reserve_store_ok()
    {
        $user = User::factory()->create();

        $param = [
            'menu_id' => 2,
            'time' => "2022-09-04/10:00:00",
        ];

        $param1 = [
            'user_id' =>  $user->id,
            'menu_id' => 2,
            'start_date' => "2022-09-04 10:00:00",
            'end_date' => "2022-09-04 11:00:00",
            'reserve_type' => 1,
        ];

        $response = $this->actingAs($user)->post("/calendar/store",$param);
        $response->assertStatus(302);

        // $response->assertRedirect('/');
        // $this->assertDatabaseHas('reserves',$param1);//dbに値があること（更新された）

    }

}

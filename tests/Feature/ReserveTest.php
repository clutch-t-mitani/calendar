<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Reserve;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;

class ReserveTest extends TestCase
{
    use WithFaker;
    // テスト実行ごとにDBをリフレッシュ
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function setUp(): void
    {
        parent::setUp();
        $this->seed('MenuSeeder');

    }

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

    // //正しいメニューIDで予約が行える事
    public function test_reserve_store_ok()
    {
        $user = User::factory()->create(['role' => 9]);
        $param = [
            'menu_id' => 1,
            'time' => '2022-09-20/15:00:00'
        ];

        $result = [
            'user_id' => $user->id,
            'menu_id' => 1,
            'start_date' => '2022-09-20 15:00:00',
            'end_date' => '2022-09-20 15:30:00',
            'reserve_type' => 1,
        ];

        $response = $this->actingAs($user)->post("/calendar/store",$param);
        $response->assertStatus(302);
        $response->assertRedirect('/');

        $this->assertDatabaseHas('reserves',$result);//dbに値があること（更新された）
    }

    // ユーザー権限のアカウントでログインしているユーザが予約管理画面にアクセスできないこと
    public function test_manager_index_ng()
    {
        $user = User::factory()->create(['role' => 9]);
        $response = $this->actingAs($user)->get("/manager/index");
        $response->assertStatus(403);
    }

    //マネージャー権限でログインしているユーザが予約管理画面にアクセスできる(200)
    public function test_manager_index()
    {
        $user = User::factory()->create(['role' => 5]);
        $response = $this->actingAs($user)->get("/manager/index");
        $response->assertStatus(200);

    }

    // マネージャー権限でログインしているユーザが予約をキャンセルできる
    public function test_Reserve_cancel_ok()
    {
        $user = User::factory()->create(['role' => 5]);
        $reserve = Reserve::factory()->create(['user_id' => $user->id]);

        $param['id'] = [$reserve->id];
        $response = $this->actingAs($user)->post("/manager/delete/",$param);

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    // マネージャー権限でログインしているユーザが予約を複数キャンセルできる
    public function test_Reserves_cancel_ok()
    {
        // $this->seed('MenuSeeder');
        $user = User::factory()->create(['role' => 5]);
        $reserves = Reserve::factory(3)->create(['user_id' => $user->id]);

        foreach ($reserves as $key => $reserve) {
            $params['id'][] = $reserve->id;
        }
        $response = $this->actingAs($user)->post("/manager/delete/",$params);

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    // ユーザ権限でログインしているユーザが予約をキャンセルできない
    public function test_Reserves_cancel_user_ng()
    {
        // $this->seed('MenuSeeder');
        $user = User::factory()->create(['role' => 9]);
        $reserves = Reserve::factory(3)->create(['user_id' => $user->id]);

        foreach ($reserves as $key => $reserve) {
            $params['id'][] = $reserve->id;
        }
        $response = $this->actingAs($user)->post("/manager/delete/",$params);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
        // $response->assertRedirect('/');
    }

    //予約時間が重なった際、予約ができない
    public function test_reserve_store_ng()
    {
        $user = User::factory()->create(['role' => 9]);
        $param = [
            'menu_id' => 1,
            'time' => '2022-09-20/15:00:00'
        ];

        $result = [
            'user_id' => $user->id,
            'menu_id' => 1,
            'start_date' => '2022-09-20 15:00:00',
            'end_date' => '2022-09-20 15:30:00',
            'reserve_type' => 1,
        ];

        $response = $this->actingAs($user)->post("/calendar/store",$param);
        $response->assertStatus(302);
        $response->assertRedirect('/');
        $this->assertDatabaseHas('reserves',$result);//dbに値があること（更新された）

        $param2 = [
            'menu_id' => 2,
            'time' => '2022-09-20/15:00:00'
        ];

        $result2 = [
            'user_id' => $user->id,
            'menu_id' => 2,
            'start_date' => '2022-09-20 15:00:00',
            'end_date' => '2022-09-20 15:30:00',
            'reserve_type' => 1,
        ];

        $response = $this->actingAs($user)->post("/calendar/store",$param2);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('reserves',$result2);//dbに値があること（更新された）

    }
}

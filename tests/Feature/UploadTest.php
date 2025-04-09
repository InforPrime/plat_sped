<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_should_can_upload_file(): void
    {
        Storage::fake();

        Cliente::factory()->create([
            'nome_modelo' => 'ModeloTeste'
        ]);

        $user = User::factory()->create([
            'role' => 'admin',
            'password' => 'password',
        ]);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->actingAs($user)->post('/api/arquivo-upload', [
            'arquivo' => UploadedFile::fake()->create('ModeloTeste.rar', 100)
        ]);

        $response->assertOk()
            ->assertJson([
                'message' => 'Arquivo enviado com sucesso.'
            ]);

        $this->assertDatabaseHas('arquivos', [
            'nome' => 'ModeloTeste.rar',
            'caminho' => 'speds/ModeloTeste.rar'
        ]);

        Storage::assertExists('speds/ModeloTeste.rar');
    }

    public function test_should_cant_upload_exists_file(): void
    {
        Storage::fake();

        Cliente::factory()->create([
            'nome_modelo' => 'ModeloTeste'
        ]);

        $user = User::factory()->create([
            'role' => 'admin',
            'password' => 'password',
        ]);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->actingAs($user)->post('/api/arquivo-upload', [
            'arquivo' => UploadedFile::fake()->create('ModeloTeste.rar', 100)
        ]);

        $response->assertOk()
            ->assertJson([
                'message' => 'Arquivo enviado com sucesso.'
            ]);

        $response = $this->actingAs($user)->post('/api/arquivo-upload', [
            'arquivo' => UploadedFile::fake()->create('ModeloTeste.rar', 100)
        ]);

        $response->assertConflict()
            ->assertJson([
                'message' => 'Arquivo já existe.'
            ]);
    }

    public function test_should_cant_upload_file_without_cliente(): void
    {
        Storage::fake();

        $user = User::factory()->create([
            'role' => 'admin',
            'password' => 'password',
        ]);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->actingAs($user)->post('/api/arquivo-upload', [
            'arquivo' => UploadedFile::fake()->create('ModeloTeste.rar', 100)
        ]);

        $response->assertNotFound()
            ->assertJson([
                'message' => 'Cliente não encontrado para este arquivo.'
            ]);
    }
}

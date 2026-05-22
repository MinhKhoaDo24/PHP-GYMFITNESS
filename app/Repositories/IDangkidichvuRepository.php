<?php

namespace App\Repositories;

interface IDangkidichvuRepository
{
    public function query();
    public function countAll();
    public function countByStatus($status);

    public function store(array $data);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);

    public function getEnumValues(string $table, string $column): array;
    public function getMonUaThich();
    public function getCoSoTap();
    public function getGioMongMuon();
}

<?php

namespace App\Repositories;

use App\Models\Dangkidichvu;
use Illuminate\Support\Facades\DB;

class DangkidichvuRepository implements IDangkidichvuRepository
{
    /** =========================
     * CRUD
     * ========================= */

    public function getAll()
    {
        return Dangkidichvu::orderBy('id_dang_ky', 'DESC')->paginate(10);
    }

    public function query()
    {
        return Dangkidichvu::query();
    }

    public function find($id)
    {
        return Dangkidichvu::findOrFail($id);
    }

    public function store(array $data)
    {
        return Dangkidichvu::create($data);
    }

    public function update($id, array $data)
    {
        return Dangkidichvu::where('id_dang_ky', $id)->update($data);
    }

    public function delete($id)
    {
        return Dangkidichvu::where('id_dang_ky', $id)->delete();
    }


    /** =========================
     * COUNT THỐNG KÊ
     * ========================= */

    public function countAll()
    {
        return Dangkidichvu::count();
    }

    public function countByStatus($status)
    {
        return Dangkidichvu::where('trangthai', $status)->count();
    }


    /** =========================
     * ENUM HANDLER
     * ========================= */


    public function getEnumValues(string $table, string $column): array
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'pgsql') {
            $row = DB::table('information_schema.columns')
                ->select('udt_name', 'data_type')
                ->where('table_name', $table)
                ->where('column_name', $column)
                ->first();

            if (!$row || $row->data_type !== 'USER-DEFINED') {
                return [];
            }

            $enumType = $row->udt_name;

            $values = DB::table('pg_type as t')
                ->join('pg_enum as e', 't.oid', '=', 'e.enumtypid')
                ->join('pg_catalog.pg_namespace as n', 'n.oid', '=', 't.typnamespace')
                ->where('t.typname', $enumType)
                ->orderBy('e.enumsortorder')
                ->pluck('e.enumlabel')
                ->toArray();

            return $values;
        }

        if ($driver === 'mysql') {
            $type = DB::table('information_schema.columns')
                ->where('table_name', $table)
                ->where('column_name', $column)
                ->value('COLUMN_TYPE');

            if (!$type) {
                return [];
            }

            if (preg_match('/^enum\((.*)\)$/', $type, $matches)) {
                return collect(explode(',', $matches[1]))
                    ->map(fn($v) => trim($v, " '\""))
                    ->values()
                    ->toArray();
            }

            return [];
        }

        return [];
    }



    public function getMonUaThich()
    {
        return [
            'gym',
            'yoga',
            'boxing',
            'dance',
            'cardio'
        ];
    }

    public function getCoSoTap()
    {
        return [
            '12-Chùa Bộc',
            '12-Cầu Giấy'
        ];
    }

    public function getGioMongMuon()
    {
        return [
            '07:00 - 09:00',
            '09:00 - 11:00',
            '13:00 - 15:00',
            '15:00 - 17:00',
            '17:00 - 19:00',
            '19:00 - 21:00',
            '21:00 - 23:00'
        ];
    }
}

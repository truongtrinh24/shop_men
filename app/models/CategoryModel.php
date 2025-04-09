<?php
class CategoryModel extends Model {
    public static function getAll() {
        $db = new DB();
        return $db->table('category')->get();
    }

    public static function getById($id) {
        $db = new DB();
        return $db->table('category')->where('id', '=', $id)->first();
    }

    public static function insert($data) {
        $db = new DB();
        return $db->table('category')->insert($data);
    }

    public static function update($id, $data) {
        $db = new DB();
        return $db->table('category')->where('id', '=', $id)->update($data);
    }

    public static function delete($id) {
        $db = new DB();
        return $db->table('category')->where('id', '=', $id)->delete();
    }
}

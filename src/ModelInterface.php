<?php
namespace KGaming\Core;

interface ModelInterface
{
    public function find();
    public function where($where);
    public function limit($limit);
    public function offset($offset);
    public function set($k,$v);
    public function get($id);
    public function fetch();
    public function exec();
    public function update($id);
    public function save();
    public function remove($id);
}

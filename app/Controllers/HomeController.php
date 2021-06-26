<?php

namespace App\Controllers;

use App\Helpers\Params;
use App\Helpers\View;
use App\Models\User;
use App\Models\Member;

class HomeController
{
    public function getTree()
    {
        $name = Params::get('id');
        $member = Member::find($name);
        if (!$member) {
            echo "Member Not Found";
            die();
        }
        $data_member = Member::getTree($member->parent_id);
        $temp_children = array();
        $data = array();
        foreach ($data_member as $key => $value) {
            if ($temp_children[$value->id]) {
                if ($value->id != 0) {
                    $temp_children[$value->parent_id][] = ["name" => $value->name, "children" => $temp_children[$value->id]];
                }
                $data[$value->parent_id] = ["name" => $value->name, "children" => $temp_children[$value->id]];
                if ($value->id != 0) {
                    unset($temp_children[$value->id]);
                    unset($data[$value->id]);
                }
            } else {
                $temp_children[$value->parent_id][] = ["name" => $value->name, "children" => array()];
            }
        }
        print_r(json_encode($data));
        die();
    }

    public function getParent()
    {
        $name = Params::get('id');
        $member = Member::find($name);
        if (!$member) {
            echo "Member Not Found";
            die();
        }
        $member_child = Member::find($name);
        $temp_parent = $member_child->id;
        $member = Member::getParent($member_child->parent_id);
        $data = array();
        foreach ($member as $key => $value) {
            if ($value->id == $temp_parent) {
                $data[] = $value->name;
                $temp_parent = $value->parent_id;
            }
        }
        print_r(json_encode($data));
        die();
    }

    public function getChildren()
    {
        $name = Params::get('id');
        $member = Member::find($name);
        if (!$member) {
            echo "Member Not Found";
            die();
        }
        $member_child = Member::find($name);
        $member = Member::getChild($member_child->id);
        $data = array();
        foreach ($member as $key => $value) {
            $data[] = $value->name;
        }
        print_r(json_encode($data));
        die();
    }

}

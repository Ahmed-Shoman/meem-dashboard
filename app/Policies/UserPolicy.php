<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    // الـ Admin لديه صلاحيات كاملة
    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    // التحقق من إمكانية عرض أي مستخدم
    public function viewAny(User $user)
    {
        return true; // الكل يمكنه الرؤية، لكن سيتم التصفية لاحقًا في الـ Resource
    }

    // التحقق من إمكانية عرض مستخدم معين
    public function view(User $user, User $model)
    {
        // المستخدم العادي يمكنه رؤية نفسه أو المستخدمين في نفس البرنامج
        return $user->id === $model->id || $user->program_id === $model->program_id;
    }

    // التحقق من إمكانية إنشاء مستخدم
    public function create(User $user)
    {
        return $user->isAdmin(); // فقط الـ Admin يمكنه الإنشاء
    }

    // التحقق من إمكانية تعديل مستخدم
    public function update(User $user, User $model)
    {
        return $user->isAdmin(); // فقط الـ Admin يمكنه التعديل
    }

    // التحقق من إمكانية حذف مستخدم
    public function delete(User $user, User $model)
    {
        return $user->isAdmin(); // فقط الـ Admin يمكنه الحذف
    }
}

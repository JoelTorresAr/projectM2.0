<?php

namespace App;

use Bitfumes\Multiauth\Model\Admin as AdminModel;


class Admin extends AdminModel
{
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','staff_id', 'email', 'description','password', 'active'];

    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      'password', 'remember_token','pivot'
  ];

  /**
   * Get user permissions and roles.
   *
   * @return json
   */
  public function jsPermissions()
  {
    return json_encode([
      'roles' => $this->getRoleNames(),
      'permissions' => $this->getAllPermissions()->pluck('name'),
    ]);
  }

  /**
   * Get the staff record associated with the admin
   */
  public function staff()
  {
    return $this->hasOne('App\models\Staff');
  }
}

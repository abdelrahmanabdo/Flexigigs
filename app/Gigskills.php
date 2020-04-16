<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Gigskills extends Model
{
    protected $table = 'gigskills';
    protected $fillable = ['category_id','gigs_id'];
    public function gig(){
     return $this->belongsTo(Gigs::class);
    }
    public function category(){
     return $this->hasOne(Category::class,'id','category_id');
    }
}

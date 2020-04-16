<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Gigattach extends Model
{
    protected $table = 'gigattach';
    protected $fillable = ['filename','type','size','gigs_id'];
    public function gig() {
     return $this->belongsTo(Gigs::class);
    }
}

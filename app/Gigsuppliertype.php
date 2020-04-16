<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Flexihelp;

class Gigsuppliertype extends Model
{
    protected $table = 'gigsuppliertype';
    protected $fillable = ['gigs_id','type'];
    protected $appends = ['supplier_type'];
    public function gig(){
     return $this->belongsTo(Gigs::class);
    }
    public function getSupplierTypeAttribute(){
     return Flexihelp::supplier_type($this->type,'one');
    }
}

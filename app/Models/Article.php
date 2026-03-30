<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Decision;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Article extends Model
{   
    use HasFactory;
    
    protected $fillable = [
        'title',
        'short_desc',
        'full_desc',
        'category_id',
        'status',
        'user_id'
    ];

    //BELONGS TO
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //hasMany
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function decisions() {
        return $this->hasMany(Decision::class);
    }

    //SCOPES
    public function scopeApproved($query) {
        return $query->where('status', 'approved');
    }

    public function scopeOnModeration($query) {
        return $query->where('status', 'moderation');
    }

    public function scopeDeclined($query) {
        return $query->where('status', 'declined');
    }

    public function scopeUserCanVote($query) {
        return $query->whereDoesntHave('decisions', function($q) {
            $q->where('user_id', Auth::id());
        });
    }

    public function scopeUserCantVote($query) {
        return $query->whereHas('decisions', function($q) {
            $q->where('user_id', Auth::id());
        });
    }

    public function scopeUserNotAuthor($query) {
        return $query->where('user_id', '!=', Auth::id());
    }

    public function scopeUserAuthor($query) {
        return $query->where('user_id', '=', Auth::id());
    }

    public function scopeVotesBlock($query) {
        return $query->withSum(['decisions as approvedVotes' => function($q) {$q->where('decision_value', '>', 0);}], 'decision_value')
                        ->withSum(['decisions as declinedVotes' => function($q) {$q->where('decision_value', '<', 0);}], 'decision_value')
                        ->withSum('decisions as sumVotes', 'decision_value');
    }

    public function scopeIsUserCanVote($query) {
        return $query->withExists(['decisions as canVote' => function($q) {$q->where('user_id', Auth::id());}]);
    }

    //filter by status
    public function scopeArticleStatus($query, $status) {
        return $query->where('status', $status);
    }

    //search
    public function scopeSearch($query, $line) {
        return $query->where('title', 'like', "%$line%")
                        ->orWhere('short_desc', 'like', "%$line%")
                        ->orWhere('full_desc', 'like', "%$line%");
    }

    //check votes and change article status
    public function checkStatus() {
        $sum = $this->decisions()->sum('decision_value');

        if($sum >= 10) {
            $this->status = 'approved';
        }

        if($sum <= -5) {
            $this->status = 'declined';
        }

        $this->save();
    }
}

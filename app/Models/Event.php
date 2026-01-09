<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * @property string|null $start_date
 * @property string|null $end_date
 */
class Event extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uid',
        'event_name',
        'start_date',
        'end_date',
        'event_code',
        'event_slug',
        'event_location',
        'status',
        'meta_title',
        'meta_desc',
        'meta_keywords',
        'featured_image',
        'conference_registration_fee',
        'networking_dinner_fee',
        'created_by',
        'updated_by',
        'deleted_by',
        'is_news',
        'activities_status',
        'news_desc',
        'news_admin_desc',
        'publish_date'
    ];

    public function GetEventWorkshops(): HasMany
    {
        return $this->hasMany(EventWorkshop::class, 'event_id', 'id')->orderBy('sorting_order', 'asc')->with(['getEventDetails', 'getCreatorDetails', 'getModifierDetails', 'getWorkshopPrograms', 'getWorkshopProgramsOrderly']);
    }

    public function getCreator(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function getModifier(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function getFeaturedImage(): HasOne
    {
        return $this->hasOne(MediaManager::class, 'media_uid', 'featured_image');
    }

    public function getEventgallery(): HasMany
    {
        return $this->hasMany(EventGallery::class, 'event_id', 'id');
    }

    public function getEventSpeakers(): HasMany
    {
        return $this->hasMany(EventSpeakers::class, 'event_id', 'id')->with('getSpeakerImage');
    }

    public function getEventTabs(): HasMany
    {
        return $this->hasMany(EventTab::class, 'event_id', 'id')->with('getTabButtons')->orderBy('tab_sort_order', 'asc');
    }

    public function getEventWorkshopOptional(): HasMany
    {
        return $this->hasMany(EventWorkshopOptional::class, 'event_id', 'id');
    }


    // public static function boot()
    // {
    //     parent::boot();
    //     self::deleting(function ($post) {
    //         $post->getEventTabs()->each(function ($val) {
    //             foreach ($val->getTabButtons() as $value) {
    //                 $value->deleted_by = Auth::id();
    //                 $value->delete();
    //                 // EventTabButton::whereId($value->id)->update(['deleted_by' => Auth::id()]);
    //                 // EventTabButton::whereId($value->id)->delete();
    //             }
    //             // $val->deleted_by = Auth::id();
    //             // $val->save();
    //             // EventTab::whereId($val->id)->update(['deleted_by' => Auth::id()]);
    //             $val->delete();
    //         });
    //         $post->getEventgallery()->each(function ($val) {
    //             // EventGallery::whereId($val->id)->update(['deleted_by' => Auth::id()]);
    //             // EventGallery::whereId($val->id)->delete();
    //             $val->delete();
    //         });
    //         // $post->getEventSpeakers()->each(function ($val) {
    //         //     // EventSpeakers::whereId($val->id)->update(['deleted_by' => Auth::id()]);
    //         //     // EventSpeakers::whereId($val->id)->delete();
    //         //     $val->delete();
    //         // });
    //         $post->GetEventWorkshops()->each(function ($val) {
    //             foreach ($val->getWorkshopPrograms() as $value) {
    //                 EventWorkshopPrograms::whereId($value->id)->update(['deleted_by' => Auth::id()]);
    //                 EventWorkshopPrograms::whereId($value->id)->delete();
    //             }
    //             EventWorkshop::whereId($val->id)->update(['deleted_by' => Auth::id()]);
    //             EventWorkshop::whereId($val->id)->delete();
    //         });

    //         $post->getEventWorkshopOptional()->each(function ($val) {
    //             EventWorkshopOptional::whereId($val->id)->update(['deleted_by' => Auth::id()]);
    //             EventWorkshopOptional::whereId($val->id)->delete();
    //         });
    //     });
    // }
}

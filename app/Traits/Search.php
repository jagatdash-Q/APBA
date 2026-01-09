<?php

namespace App\Traits;

use App\Models\AboutUsPage;
use App\Models\CareerListing;
use App\Models\BlogListing;
use App\Models\CareerContent;
use App\Models\Media;
use App\Models\OurTeamListingContent;
use App\Models\Sitepage;
use TeamTNT\TNTSearch\Indexer\TNTIndexer;

trait Search
{


    public function getSuggestions($query, $search_models = [], $main_datasets = null)
    {
        $indexer = new TNTIndexer;
        $trigrams = $indexer->buildTrigrams($query);
        $suggestions = [];
        $blog_lists = $careers = $career_lists = $medias = $trainings = $sitepages = $our_teams_listing =  [];

        if (count($search_models) > 0) {
            foreach ($search_models as $search_key) {
                switch ($search_key) {
                    case 'blog_listing':
                        $blog_lists =  BlogListing::search($trigrams)->get();
                        $suggestions  =   $this->filterDataSetByConditions($this->sortByLevenshteinDistance($blog_lists, $query),  $main_datasets['blog_uids'], 'blog');
                        if (count($suggestions) > 0) {
                            return $suggestions;
                        }

                    case 'career':
                        $careers = CareerContent::search($trigrams)->get();
                        $suggestions  =   $this->filterDataSetByConditions($this->sortByLevenshteinDistance($careers, $query), $main_datasets['career_uids'], 'career');
                        if (count($suggestions) > 0) {
                            return $suggestions;
                        }
                    case 'career_listing':
                        $career_lists = CareerListing::search($trigrams)->get();
                        $suggestions  =  $this->filterDataSetByConditions($this->sortByLevenshteinDistance($career_lists, $query), $main_datasets['career_uids'], 'career_listing');
                        if (count($suggestions) > 0) {
                            return $suggestions;
                        }


                    case 'media':
                        $medias = Media::search($trigrams)->get();
                        $suggestions  =  $this->filterDataSetByConditions($this->sortByLevenshteinDistance($medias, $query),  $main_datasets['media_ids'], 'media');
                        if (count($suggestions) > 0) {
                            return $suggestions;
                        }


                    case 'training':
                        $trainings = Sitepage::search($trigrams)->get();
                        $suggestions  = $this->filterDataSetByConditions($this->sortByLevenshteinDistance($trainings, $query), $main_datasets['training_ids'], 'training');
                        if (count($suggestions) > 0) {
                            return $suggestions;
                        }


                    case 'Sitepage':
                        $sitepages = Sitepage::search($trigrams)->get();
                        $suggestions  =   $this->filterDataSetByConditions($this->sortByLevenshteinDistance($sitepages, $query), $main_datasets['sitepage_ids'], 'Sitepage');
                        if (count($suggestions) > 0) {
                            return $suggestions;
                        }
                    case 'our_teams_listing':
                        $our_teams_listing_content = OurTeamListingContent::search($trigrams)->get();
                        $suggestions  =   $this->filterDataSetByConditions($this->sortByLevenshteinDistance($our_teams_listing_content, $query), $main_datasets['our_team_listing_uids'], 'our_teams_listing');
                        if (count($suggestions) > 0) {
                            return $suggestions;
                        }

                    case 'about_us_page':
                        $about_us_content = AboutUsPage::search($trigrams)->get();
                        $suggestions  =   $this->filterDataSetByConditions($this->sortByLevenshteinDistance($about_us_content, $query), $main_datasets['about_us_ids'], 'about_us_page');
                        if (count($suggestions) > 0) {
                            return $suggestions;
                        }
                }
            }
        }
        return $suggestions;
    }

    public function sortByLevenshteinDistance($suggestions, $query)
    {
        $suggestions = $suggestions->filter(function ($module) use ($query) {
            $module->distance = levenshtein($query, $module->page_name);
            $page_slug_distance = levenshtein($query, $module->page_slug);
            $meta_title_distance = levenshtein($query, $module->meta_title);
            $meta_keywoard_distance = levenshtein($query, $module->meta_keywoard);
            $meta_description_distance = levenshtein($query, $module->meta_description);
            return $module->distance < 4 || $page_slug_distance < 4 || $meta_title_distance < 4 || $meta_keywoard_distance < 4 || $meta_description_distance < 4;
        });

        $sorted = $suggestions->sort(function ($a, $b) {
            if ($a->distance === $b->distance) {
                if ($a->population === $b->population) {
                    return 0;
                }
                return $a->population > $b->population ? -1 : 1;
            }
            return $a->distance < $b->distance ? -1 : 1;
        });
        return $sorted->values()->take(5);
    }

    // public function isExactMatch($query, $result, $inDataSet = [], $page_type)
    // {
    //     $elem1 = $elem2 = false;
    //     if (in_array($page_type, ['Sitepage', 'training', 'media'])) {
    //         $elem1 = in_array($result->content_id, $inDataSet);
    //     }
    //     if (in_array($page_type, ['career', 'career_listing'])) {
    //         $elem1 = in_array($result->career_uid, $inDataSet);
    //     }
    //     if (in_array($page_type, ['blog'])) {
    //         $elem1 = in_array($result->blog_uid, $inDataSet);
    //     }
    //     // $elem2 =  array_search($query, ['page_name' => $result->page_name, 'page_slug' => $result->page_slug, 'meta_title' => $result->meta_title, 'meta_keywoard' => $result->meta_keywoard, 'meta_description' => $result->meta_description]);

    //     $elem2 = $this->array_search_partial(array('page_name' => $result->page_name, 'page_slug' => $result->page_slug, 'meta_title' => $result->meta_title, 'meta_keywoard' => $result->meta_keywoard, 'meta_description' => $result->meta_description), $query);
    //     return  $elem1 & $elem2;
    //     // $query === $result->page_name ? true : false;

    // }

    function array_search_partial($arr, $keyword)
    {
        foreach ($arr as $index => $string) {
            if (strpos($string, $keyword) !== FALSE) {
                return $index;
            }
        }
    }

    public function allExactMatches($query, $results, $inDataSet = [], $page_type = null)
    {

        $final_array = [];
        foreach ($results as $result) {
            $elem1  = false;
            if (in_array($page_type, ['Sitepage', 'training', 'media'])) {
                $elem1 = in_array($result->content_id, $inDataSet);
            }
            if (in_array($page_type, ['career', 'career_listing'])) {
                $elem1 = in_array($result->career_uid, $inDataSet);
            }
            if ($page_type == 'blog') {
                $elem1 = in_array($result->blog_uid, $inDataSet);
            }

            // if (array_search($query, ['page_name' => $result->page_name, 'page_slug' => $result->page_slug, 'meta_title' => $result->meta_title, 'meta_keywoard' => $result->meta_keywoard, 'meta_description' => $result->meta_description]) &&  $elem1)
            // if($this->array_search_partial(array('page_name' => $result->page_name, 'page_slug' => $result->page_slug, 'meta_title' => $result->meta_title, 'meta_keywoard' => $result->meta_keywoard, 'meta_description' => $result->meta_description), $query) && $elem1) 
            //     array_push($final_array, $result);
            switch ($page_type) {
                case 'Sitepage':
                    if ($this->array_search_partial(array('page_name' => $result->page_name, 'page_slug' => $result->page_slug, 'meta_title' => $result->meta_title, 'meta_keywoard' => $result->meta_keywoard, 'meta_description' => $result->meta_description, 'page_title' => $result->page_title, 'content_description' => $result->content_description), $query) && $elem1) {
                        $final_array[] = $result;
                    }
                    break;


                case 'training':

                case 'media':
                    if ($this->array_search_partial(array('page_name' => $result->page_name, 'page_slug' => $result->page_slug, 'meta_title' => $result->meta_title, 'meta_keywoard' => $result->meta_keywoard, 'meta_description' => $result->meta_description), $query) && $elem1) {
                        $final_array[] = $result;
                    }
                    break;

                case 'career_listing':
                    if ($this->array_search_partial(array('page_name' => $result->page_name, 'page_slug' => $result->page_slug, 'meta_title' => $result->meta_title, 'meta_keywoard' => $result->meta_keywoard, 'meta_description' => $result->meta_description, 'title' => $result->title,  'job_desc_body' => $result->job_desc_body, 'excerpt_desc' => $result->excerpt_desc), $query) && $elem1) {
                        $final_array[] = $result;
                    }
                    break;
                case 'career':
                    if ($this->array_search_partial(array('page_name' => $result->page_name, 'page_slug' => $result->page_slug, 'meta_title' => $result->meta_title, 'meta_keywoard' => $result->meta_keywoard, 'meta_description' => $result->meta_description, 'title' => $result->title, 'desc' => $result->desc, 'owe_title' => $result->owe_title, 'co_title' => $result->co_title, 'co_desc' => $result->co_desc), $query) && $elem1) {
                        $final_array[] = $result;
                    }
                    break;

                case 'blog':
                    if ($this->array_search_partial(array('page_name' => $result->page_name, 'page_slug' => $result->page_slug, 'meta_title' => $result->meta_title, 'meta_keywoard' => $result->meta_keywoard, 'meta_description' => $result->meta_description, 'title' => $result->title, 'body' => $result->body), $query) && $elem1) {
                        $final_array[] = $result;
                    }
                    break;
            }
        }
        return $final_array;
    }

    public function filterDataSetByConditions($results, $inDataSet = [], $page_type = null)
    {
        $final_array = [];
        foreach ($results as $result) {
            $elem1  = false;
            if (in_array($page_type, ['Sitepage', 'training', 'media','about_us_ids'])) {
                $elem1 = in_array($result->content_id, $inDataSet);
            } elseif (in_array($page_type, ['career', 'career_listing'])) {
                $elem1 = in_array($result->career_uid, $inDataSet);
            } elseif ($page_type == 'blog') {
                $elem1 = in_array($result->blog_uid, $inDataSet);
            } elseif ($page_type == 'our_teams_listing') {
                $elem1 = in_array($result->uid, $inDataSet);
            }

            if ($elem1) {
                $final_array[] = $result;
            }
        }
        return $final_array;
    }
}

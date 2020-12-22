<?php

namespace App;

use App\Traits\FilterHelperTrait;
use App\Traits\KpiFilterTrait;
use App\Traits\KpiUserScoreTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class KpiUserScore extends Model
{

	use KpiUserScoreTrait;
	use KpiFilterTrait;
	use FilterHelperTrait;

    //
	protected  $table = 'kpi_user_score';

	function user(){
		return $this->belongsTo(User::class,'user_id');
	}

	function kpi_data(){
		return $this->belongsTo(KpiData::class,'kpi_data_id');
	}


	public function loadFilters()
    {
        // TODO: Implement loadFilters() method.
        $ref = $this;
        $this->addFilter(['user_id'], function (Builder $builder, $filter) use ($ref) {
            return $ref->filterByUserId($builder, $filter);
        });

        $this->addFilter(['kpi_data_id'], function (Builder $builder, $filter) use ($ref) {
            return $ref->filterByKpiDataId($builder, $filter);
        });


        $this->addFilter(['kpi_year_id', 'user_id'], function (Builder $builder, $filter) {

            return $builder->whereHas('kpi_data', function (Builder $builder) use ($filter) {

                return $builder->whereHas('interval', function (Builder $builder) use ($filter) {

                    return $builder->whereHas('year', function (Builder $builder) use ($filter) {

                        return $builder->where('id', $filter['kpi_year_id']);

                    });

                });

            })->whereHas('user', function (Builder $builder) use ($filter) {

                return $builder->where('id', $filter['user_id']);

            });


        });


        $this->addFilter(['kpi_year_id', 'user_id', 'kpi_interval_id'], function (Builder $builder, $filter) {

            return $builder->whereHas('kpi_data', function (Builder $builder) use ($filter) {

                return $builder->whereHas('interval', function (Builder $builder) use ($filter) {

                    return $builder->where('id', $filter['kpi_interval_id'])->whereHas('year', function (Builder $builder) use ($filter) {

                        return $builder->where('id', $filter['kpi_year_id']);

                    });

                });

            })->whereHas('user', function (Builder $builder) use ($filter) {

                return $builder->where('id', $filter['user_id']);

            });


        });

    }


	//createIndividualKpi




}

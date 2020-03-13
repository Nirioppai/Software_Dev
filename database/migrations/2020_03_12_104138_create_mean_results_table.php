<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeanResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        Create View mean_results As
        (
          SELECT 

            AVG(distinct total_raw) AS AverageTotalRaw,
            AVG(distinct total_scaled) AS AverageTotalScaled,
            AVG(distinct total_sai) AS AverageTotalSAI,
            AVG(distinct total_percentile) AS AverageTotalPercentile,
            AVG(distinct total_stanine) AS AverageTotalStanine,

            AVG(distinct verbal_comprehension) AS AverageVerbalComprehension,
            AVG(distinct verbal_reasoning) AS AverageVerbalReasoning,
            AVG(distinct verbal_raw) AS AverageVerbalRaw,
            AVG(distinct verbal_scaled) AS AverageVerbalScaled,
            AVG(distinct verbal_sai) AS AverageVerbalSAI,
            AVG(distinct verbal_percentile) AS AverageVerbalPercentile,
            AVG(distinct verbal_stanine) AS AverageVerbalStanine,

            AVG(distinct quantitative_reasoning) AS AverageQuantitativeReasoning,
            AVG(distinct figural_reasoning) AS AverageFiguralReasoning,
            AVG(distinct nonverbal_raw) AS AverageNonVerbalRaw,
            AVG(distinct nonverbal_scaled) AS AverageNonVerbalScaled,
            AVG(distinct nonverbal_sai) AS AverageNonVerbalSAI,
            AVG(distinct nonverbal_percentile) AS AverageNonVerbalPercentile,
            AVG(distinct nonverbal_stanine) AS AverageNonVerbalStanine,

            batch

            FROM student_batch

            group by batch


        )
      ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mean_results');
    }
}

// Copyright 2012 fvn.no All Rights Reserved.

/* Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * @author
 * Atle Brandt, atle.brandt@gmail.com
 *
 * @fileoverview
 * fvn.no local extensions for the Google Analytics gadash toolkit
 */

// Create namespace for this library if not already created.
var fvdash = fvdash || {};

// Namespace for util object. For common handler functions
fvdash.util = fvdash.util || {};

/**
 * Draws two charts, each comparing latest/current data with historical data
 * @param {Object} respons the standard query response for gadash
 */
fvdash.drawDayCompCharts =  function (response) {

	dataTableC = gadash.util.getDataTable(response, this.config.type);

	numDays = this.config['last-n-days'];
	if (numDays == notToday) { offSet = (numDays-1) * 24;  }
	else { offSet = numDays * 24;};
	
	dataView1 = new google.visualization.DataView(dataTableC);
	dataView1.setRows(0, dayLength);

	dataView2 = new google.visualization.DataView(dataTableC);
	dataView2.setRows(offSet, offSet + dayLength);

	
   dataViewJoin = google.visualization.data.join(dataView1, dataView2, 'inner', [[1,1]], [2], [2]);
	dataViewJoin.setColumnLabel(1, this.config.columnLabels[1]);
	dataViewJoin.setColumnLabel(2, this.config.columnLabels[2]);
	dChart1 = gadash.util.getChart(this.config.chartContainer[0], this.config.chartType);
	this.config.chartOptions.title = this.config.chartTitles[0];
	gadash.util.draw(dChart1, dataViewJoin, this.config.chartOptions);

   dataViewJoin = google.visualization.data.join(dataView1, dataView2, 'inner', [[1,1]], [4], [4]);
	dataViewJoin.setColumnLabel(1, this.config.columnLabels[1]);
	dataViewJoin.setColumnLabel(2, this.config.columnLabels[2]);
	dChart2 = gadash.util.getChart(this.config.chartContainer[1], this.config.chartType);
	this.config.chartOptions.title = this.config.chartTitles[1];
	gadash.util.draw(dChart2, dataViewJoin, this.config.chartOptions);

}


/**
 * Extends the values in the chart's config object with the keys in
 * the config parameters. If a key in config already exists in the chart,
 * and the value is not an object, the new value overwrites the old.
 * @param {Object} config The config object to set inside this object.
 * @return {Object} The current instance of the Chart object. Useful
 *     for chaining methods.
 */
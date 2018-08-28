import {Injectable} from "@angular/core";
import {HttpClient, HttpParams} from "@angular/common/http";

import {Status} from "../classes/status";
import {Activity} from "../classes/activity";
import {Observable} from "rxjs/Observable";

@Injectable ()
export class ActivityService {

	constructor(protected http : HttpClient) {}

	//api endpoint
	private activityUrl = "api/activity/";

	//call the activity API and get a activity object by its Id
	getactivity(activityId: string) : Observable<activity> {
		return(this.http.get<activity>(this.activityUrl, {params: new HttpParams().set("id", activityId)}));
	}

	// //call the activity API and get the activity by activity Name
	// getactivityByactivityName(activityName: string) : Observable<activity> {
	// 	return(this.http.get<activity>(this.activityUrl, {params: new HttpParams().set("activityName", activityName)}));
	// }
}
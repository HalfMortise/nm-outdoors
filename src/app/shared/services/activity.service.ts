import {Injectable} from "@angular/core";


import {Activity} from "../interfaces/activity";
import {Observable} from "rxjs/internal/Observable";
import {HttpClient, HttpParams} from "@angular/common/http";

@Injectable ()
export class ActivityService {

	constructor(protected http : HttpClient) {}

	//api endpoint
	private activityUrl = "api/activity/";

	//call the activity API and get a activity object by its Id
	getActivity(activityId: string) : Observable<Activity> {
		return(this.http.get<Activity>(this.activityUrl, {params: new HttpParams().set("id", activityId)}));
	}

	// //call the activity API and get the activity by activity Name
	// getactivityByactivityName(activityName: string) : Observable<activity> {
	// 	return(this.http.get<activity>(this.activityUrl, {params: new HttpParams().set("activityName", activityName)}));
	// }
}
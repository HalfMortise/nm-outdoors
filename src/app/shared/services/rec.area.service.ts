import {Injectable} from "@angular/core";
import {RecArea} from "../interfaces/rec.area";
import {Observable} from "rxjs";
import {HttpClient, HttpParams} from "@angular/common/http";

@Injectable()

export class RecAreaService {
	constructor(protected http : HttpClient) {}
	//api endpoint
	private recAreaUrl = "api/recArea/";

	//call the recArea API and get rec area object by its id
	getRecAreaByRecAreaId(recAreaId: string) : Observable<RecArea>{
		return(this.http.get<RecArea>(this.recAreaUrl, {params: new HttpParams().set("id", recAreaId)}));
	}

	//call the recArea API and get rec area object by its name
	getRecAreaByRecAreaName(recAreaName: string) : Observable<RecArea>{
		return(this.http.get<RecArea>(this.recAreaUrl, {params: new HttpParams().set("name", recAreaName)}));
	}

	//call the recArea API and get rec area object by its distance
	getRecAreaByRecAreaByDistance(recAreaId: string) : Observable<RecArea>{
		return(this.http.get<RecArea>(this.recAreaUrl, {params: new HttpParams().set("id", recAreaId)}));
	}

	//call the recArea API and return all rec areas
	getRecAreas(recAreaId: string) : Observable<RecArea>{
		return(this.http.get<RecArea>(this.recAreaUrl, {params: new HttpParams().set("id", recAreaId)}));
	}
}
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
}
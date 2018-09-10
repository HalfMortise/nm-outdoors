/************************************************************************************************************/
/*	Module name: sign.up.service.ts																									*/
/* Module description: Service creates a session for a user while signed into account in the web application*/
/*	Author: HalfMortise																													*/
/*	Date: 8/28/2018																														*/
/************************************************************************************************************/

/* Imports */

import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {Status} from "../interfaces/status";

/* Injectable metadata */

@Injectable()

/* Service */

export class SessionService {

	constructor(protected http:HttpClient) {}

	private sessionUrl = "api/earl-grey/";

	setSession() {

		return (this.http.get<Status>(this.sessionUrl, {}));
	}
}













//<Board>(this.boardUrl, {params: new HttpParams().set("boardProfileId", boardProfileId)})
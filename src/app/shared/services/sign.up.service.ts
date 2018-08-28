/******************************************************************************************************/
/*	Module name: sign.up.service.ts																							*/
/* Module description: Service to allow a user to create an account in the web application				*/
/*	Author: HalfMortise																											*/
/*	Date: 8/28/2018																												*/
/******************************************************************************************************/

/* Imports */

import {Injectable} from "@angular/core";
import {Status} from "../interfaces/status";
import {Observable} from "rxjs/internal/Observable";
import {SignUp} from "../interfaces/sign.up";
import {HttpClient} from "@angular/common/http";

/* Injectable metadata */

@Injectable()

/* Service */

export class SignUpService {

	constructor(protected http: HttpClient) {

	}

	private signUpUrl = "api/sign-up/";

	createProfile(signUp: SignUp) : Observable<Status> {

		return(this.http.post<Status>(this.signUpUrl, signUp));

	}
}
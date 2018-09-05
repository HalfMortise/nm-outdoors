/******************************************************************************************************/
/*	Module name: activation.service.ts																						*/
/* Module description: Service to communicate through components that an account has been activated		*/
/*	Author: HalfMortise																											*/
/*	Date: 8/28/2018																												*/
/******************************************************************************************************/

/* Imports */

import {Injectable} from "@angular/core";
import {Status} from "../interfaces/status";
import {Observable} from "rxjs/internal/Observable";
import {SignUp} from "../interfaces/sign.up";
import {HttpClient} from "@angular/common/http";
import {Subject} from "rxjs";

/* Injectable metadata */

@Injectable()

/* Service */

export class ActivationService {

	private subject : Subject<string>;

	public activationStatus : string;

	constructor() {

		this.subject = new Subject<string>();
		this.activationStatus = null;
	}

	fromValidation(status: string) {
		this.subject.next(status);
		this.activationStatus = status;
	}

	isFromValidation(): Observable<string> {
		return this.subject.asObservable();
	}
}
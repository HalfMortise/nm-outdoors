/* imports*/

import {Component, OnInit} from "@angular/core";
import {ReviewService} from "../shared/services/review.service";
import {Review} from "../shared/interfaces/review";
import {Observable} from "rxjs";



/*component*/

@Component({
	template: require("./reviewpost.html"),
	selector: "review-post"

})

export class ReviewPostComponent implements OnInit{
	reviews: Review;

	constructor(protected reviewService: ReviewService){



	}
	ngOnInit(){

	}

}

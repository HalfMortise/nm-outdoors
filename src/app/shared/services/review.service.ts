import {Injectable} from "@angular/core";

import {Status} from "../interfaces/status";
import {Review} from "../interfaces/review";
import {Observable} from "rxjs/internal/Observable";
import {HttpClient, HttpParams} from "@angular/common/http";

@Injectable ()
export class ReviewService {
	constructor(protected http : HttpClient) {}

	//define the API endpoint
	private reviewUrl = "api/review/";

	// call to the review API and delete the review in question
	deleteReview(reviewId: string) : Observable<Status> {
		return(this.http.delete<Status>(this.reviewUrl + reviewId));

	}

	// call to the review API and edit the review in question
	editReview(review : Review) : Observable<Status> {
		return(this.http.put<Status>(this.reviewUrl + review.reviewId, review));
	}

	// call to the review API and create the review in question
	createReview(review : Review) : Observable<Status> {
		return(this.http.post<Status>(this.reviewUrl, review));
	}

	// call to the review API and get a review object based on its Id
	getReview(reviewId : string) : Observable<Review> {
		return(this.http.get<Review>(this.reviewUrl + reviewId));
	}

	// call to the review API and get an array of reviews based off the profileId
	getReviewbyProfileId(reviewProfileId : string) : Observable<Review[]> {
		return(this.http.get<Review[]>(this.reviewUrl, {params: new HttpParams().set("reviewProfileId", reviewProfileId)}));
	}

	// call to the review API and get an array of reviews based off the recAreaId
	getReviewByRecAreaId(reviewRecAreaId : string) : Observable<Review[]> {
		return(this.http.get<Review[]>(this.reviewUrl, {params: new HttpParams().set("reviewRecAreaId", reviewRecAreaId)}));
	}

	// // call to the review API and get an array of reviews based off the reviewContent
	// getReviewByContent(reviewContent : string) : Observable<review[]> {
	// 	return(this.http.get<Review[]>(this.reviewUrl, {params: new HttpParams().set("reviewContent", reviewContent)}));
	// }
}
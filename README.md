# DoctrineMongoTransaction
Transaction management for MongoDB
#Requirement
1. DoctrineMongoDBBundle (http://symfony.com/doc/current/bundles/DoctrineMongoDBBundle/index.html)

#Usage
1. A request from client to server such as a transaction.
2. Only one transaction for a request.
```
Example:
//Controller
try{
		MongoDBTransaction::startTransaction();
		//Do Something
		MongoDBTransaction::commitTransaction();
}catch(\Exception $e){
	MongoDBTransaction::rollbackTransaction();
	//Do Something
}


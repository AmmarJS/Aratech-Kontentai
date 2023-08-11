<?php

use Kontent\Ai\Delivery\DeliveryClient;
use Kontent\Ai\Delivery\QueryParams;
use Illuminate\Support\Collection;

class Client {
    private static $client;
    private static $app;
    private static $query;

    /**
     * create a kontent ai client, if created, returns the previously created one.
     *
     * @return Client collection of Kontent ai items
     */
    public static function createClient() : Client {
        try {
            // Initializes an instance of the DeliveryClient client
            if(is_null(static::$app))
                $client = new DeliveryClient(env("KONTENT_AI_KEY"));
            else
                return static::$app;
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }
        static::$client = $client;
        static::$app = new Client();
        static::$query = new QueryParams();
        return static::$app;
    }

    /**
     * get items from kontent ai using item name
     *
     * @param string $item Kontent ai item name
     * 
     * @return object Kontent ai item
     */
    public function __get(string $item) : object {
        $res = static::$client->getItem($item);
        if(is_null($res)) {
            throw new \InvalidArgumentException("Item not found: $item");
        }
        return $res; 
    }

    /**
     * chain a method call to the kontent ai client
     *
     * @param string $method method name
     * 
     * @param array $arguments method arguments
     * @return Client the app instance
     */
    public function __call(string $method, array $arguments) : Client {
        if(method_exists(Query::class, $method)) {
            [$key, $val] = Query::$method($arguments);
            static::$query->data[$key] = $val; 
            return static::$app;
        } elseif(method_exists(QueryParams::class, $method)) {
            static::$query->$method(...$arguments);
            return static::$app;
        } else {
            throw new \BadMethodCallException("Method $method() does not exist");
        }
    }

    /**
     * fetch the items after filtering with query
     *
     * 
     * @return Collection $items Kontent ai collection of Kontent ai items
     */
    public function fetch() : Collection {
        if(is_null(static::$query)) {
            return new Collection(static::$client->getItems());
        } else {
            $collection = new Collection(static::$client->getItems(static::$query));
            static::$query = new QueryParams();
            return $collection;
        }
    }

    /**
     * returns the Kontent.ai delivery client instance
     *
     * 
     * @return DeliveryClient
     */
    public function getClient() : DeliveryClient {
        return static::$client;
    }

    /**
     * clears the chain query to start a new one
     *
     * 
     * @return void
     */
    public function clearQuery() : void {
        static::$query = new QueryParams();
    }
}
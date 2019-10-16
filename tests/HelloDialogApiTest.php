<?php
namespace Czim\HelloDialog\Test;

class HelloDialogApiTest extends TestCase
{

    /**
     * @test
     */
    function it_returns_an_array_for_received_json_on_a_get_request()
    {
        $this->mockResponses = [
            $this->makeJsonResponse([ 'test' => 'value' ]),
        ];

        $api = $this->makeHelloDialogApi();

        $result = $api->get();

        $this->assertEquals([ 'test' => 'value' ], $result);

        $this->assertIsApiHistoryCount(1);
        $this->assertIsApiHistoryEntryCorrectRequestOfMethod('GET');
    }
    

    /**
     * @test
     * @expectedException \Czim\HelloDialog\Exceptions\ConnectionException
     */
    function it_throws_an_exception_if_it_does_not_receive_json()
    {
        $this->mockResponses = [
            $this->makeResponse('no json!'),
        ];

        $api = $this->makeHelloDialogApi();

        $api->get();
    }

    /**
     * @test
     * @expectedException \Czim\HelloDialog\Exceptions\ConnectionException
     */
    function it_throws_an_exception_if_it_receives_a_non_200_status_code()
    {
        $this->mockResponses = [
            $this->makeResponse(json_encode([ 'test' => 'json' ]), 400),
        ];

        $api = $this->makeHelloDialogApi();

        $api->get();
    }

}

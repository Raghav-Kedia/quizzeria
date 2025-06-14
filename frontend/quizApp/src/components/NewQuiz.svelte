<script>
    import Question from "./Question.svelte";
    import { createEventDispatcher } from "svelte";

    const dispatch = createEventDispatcher();

    export let user_email;

    let quizData = {};
    let numberOfQuestions;
    let tempArray = [];

    let flag = 0;

    const createStructure = function () {
        if (numberOfQuestions > 0) {
            flag = 1;
            tempArray = [];
            for (let i = 0; i < numberOfQuestions; i++) {
                tempArray.push(i + 1);
            }
            tempArray = tempArray;
        }
    };

    const updateQuestionDatabase = function (event) {
        quizData[event.detail.questionNumber] = event.detail.questionItem;
    };

    const saveQuiz = function () {
        quizData["owner"] = user_email;
        return fetch("http://localhost/quizzeria/backend/quizAppAPI/newQuiz.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json", // Specify the content type as JSON
            },
            body: JSON.stringify(quizData), // Convert the data to JSON format
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then((data) => {
                return data; // Handle the response data
            })
            .catch((error) => {
                console.error("There was a problem with the fetch operation:", error);
            });
    };
</script>

{#if flag == 0}
    <div id="numOfQues">
        <input id="numInput" type="number" placeholder="Enter no. of questions" bind:value={numberOfQuestions} />
        <button id="createBtn" on:click={createStructure}>Create</button>
        <button on:click={() => dispatch("goBack")} id="backBtn">Go Back</button>
    </div>
{:else if flag == 1}
    {#if tempArray.length > 0}
        <div id="quizContainer">
            {#each tempArray as questionNumber}
                <Question {questionNumber} on:infoUpdate={updateQuestionDatabase} />
            {/each}
        </div>
        <button id="saveBtn" on:click={() => (flag = 2)}>Save Quiz</button>
    {/if}
    <button on:click={() => dispatch("goBack")} id="backBtn">Go Back</button>
{:else if flag == 2}
    {#await saveQuiz()}
        <h1 class="responseMsg">Inserting quiz to database...</h1>
    {:then response}
        <h1 class="responseMsg">{response["msg"]}</h1>
    {/await}
    <button on:click={() => dispatch("goBack")} id="backBtn">Go Back</button>
{/if}

<style>
    #numOfQues,
    .responseMsg {
        display: flex;
        flex-direction: column;

        /* background-color: red; */
        color: white;

        width: 40%;
        height: 200px;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;

        margin: auto;

        text-align: center;
    }

    #numInput {
        font-size: 40px;
        text-align: center;
        width: 80%;
        margin-inline: auto;
        margin-bottom: 20px;
        padding: 20px;
        border-radius: 20px;
    }

    #createBtn {
        width: 50%;
        padding-block: 15px;
        padding-inline: 20px;
        margin-inline: auto;
    }

    #saveBtn,
    #backBtn {
        padding: 20px;
        margin-top: 10px;
        margin-inline: auto;
    }

    button {
        border-radius: 40px;
        border: 2px solid white;

        font-size: 20px;

        background-color: white;
        color: rgb(104, 44, 201);

        transition: 200ms;
    }

    button:hover {
        background-color: rgb(104, 44, 201);
        color: white;
        transition: 200ms;
    }

    button:focus {
        background-color: white;
        color: rgb(104, 44, 201);
    }

    #quizContainer {
        width: 50%;
        margin-inline: auto;
        margin-top: 10px;
    }
</style>

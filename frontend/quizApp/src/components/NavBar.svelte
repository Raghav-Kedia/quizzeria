<script>
    export let displayName;
    export let photoURL;
    // export let uid;
</script>

<div class="navBar">
    <div id="logo">
        <h1>Quizzeria!!!</h1>
    </div>
    <div id="userDisplay">
        <span id="userName">Hi! {displayName}</span>
        <button
            id="profileBtn"
            on:click={() => {
                alert("Page to be added!");
            }}
        >
            <!-- svelte-ignore a11y-img-redundant-alt -->
            <img src={photoURL} id="userImage" alt="Profile Image" height="40" width="40" />
        </button>
    </div>
</div>

<style>
    .navBar {
        height: 11%;
        padding-inline: 2%;
        border-bottom: 3px solid #ac73ff;
        border-bottom-right-radius: 10px;
        border-bottom-left-radius: 10px;

        display: flex;
        justify-content: space-between;

        background-color: rgb(128 128 128 / 20%);
        backdrop-filter: blur(15px);
        color: white;
    }

    #logo {
        display: flex;
        align-items: center;
    }

    #userDisplay {
        display: flex;
        align-items: center;
        font-size: 25px;
    }

    #userName {
        margin-right: 10px;
    }

    #userImage {
        border-radius: 50%;
    }

    #profileBtn {
        border-radius: 50%;
        background: none;
    }
</style>

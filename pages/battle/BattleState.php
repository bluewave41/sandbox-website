<?php
	abstract class BattleState {
		const WON = -1;
		const PLAYERFAINTED = -2;
		const CATCHSUCCESS = -3;
		const CATCHFAILURE = -4;
	}